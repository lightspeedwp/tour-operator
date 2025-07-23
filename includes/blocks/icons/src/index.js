import { registerBlockType } from '@wordpress/blocks';
import { useState } from '@wordpress/element';
import { PanelBody, RadioControl } from '@wordpress/components';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import icons from './icons.react.js';

import './style.scss';

const IconsBlockIcon = () => (
    <svg viewBox="0 0 166 166" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
        <path fillRule="evenodd" clipRule="evenodd"
              d="m78.091 0 5.967 5.676c15.038 14.306 35.323 23.067 57.663 23.067.356 0 .711-.002 1.065-.006l6.363-.08 1.988 6.072a102.026 102.026 0 0 1 5.045 31.782c0 47.391-32.269 87.19-75.928 98.477l-2.163.559-2.163-.559C32.27 153.701 0 113.902 0 66.511c0-11.085 1.769-21.772 5.045-31.782l1.988-6.072 6.363.08c.354.004.71.006 1.065.006 22.34 0 42.625-8.761 57.664-23.067L78.09 0ZM19.846 46.033a84.814 84.814 0 0 0-2.492 20.478c0 38.459 25.662 70.919 60.737 81.006 35.075-10.087 60.738-42.547 60.738-81.006 0-7.071-.866-13.93-2.493-20.478-22.009-1.16-42.166-9.387-58.245-22.453-16.079 13.066-36.235 21.293-58.245 22.453Z"></path>
    </svg>
);

// Validate icons object
if (!icons || typeof icons !== 'object' || Object.keys(icons).length === 0) {
    console.error('Icons not properly loaded. Please run generate-icons.js');
}

const iconTypes = icons ? Object.keys(icons) : [];

registerBlockType('lsx-tour-operator/icons', {
    title: 'Icons',
    icon: IconsBlockIcon,
    attributes: {
        iconType: { type: 'string', default: iconTypes[0] },
        iconName: { type: 'string', default: '' },
    },
    edit: (props) => {
        const { attributes, setAttributes, isSelected } = props;
        const { iconType, iconName } = attributes;
        const [localType, setLocalType] = useState(iconType);
        const [localName, setLocalName] = useState(iconName);
        const [chooserOpen, setChooserOpen] = useState(!iconName);
        const [filter, setFilter] = useState(''); // New state for filter
        const blockProps = useBlockProps();
        const iconList = Object.keys(icons[localType]);
        const filteredIconList = filter
            ? iconList.filter(name => name.toLowerCase().includes(filter.toLowerCase()))
            : iconList;

        const updateType = (type) => {
            setLocalType(type);
            const newIconList = Object.keys(icons[type]);
            const nextName = newIconList.includes(localName) ? localName : newIconList[0];
            setAttributes({ iconType: type, iconName: nextName });
            setLocalName(nextName);
        };
        const updateName = (name) => {
            setLocalName(name);
            setAttributes({ iconName: name });
        };
        const handleInsert = () => {
            setAttributes({ iconType: localType, iconName: localName});
            setChooserOpen(false);
        };
        const handleEdit = () => {
            setChooserOpen(true);
        };

        return (
            <div {...blockProps}>
                <InspectorControls>
                    <PanelBody title="Icon Settings" initialOpen={true}>
                        <RadioControl
                            label="Type"
                            onChange={updateType}
							selected={localType}
							options={iconTypes.map(type => ({
								label: type.charAt(0).toUpperCase() + type.slice(1),
								value: type
							}))}
                            disabled={
                                !chooserOpen && !iconTypes.every(type => icons[type][localName])
                            }
						/>
                    </PanelBody>
                </InspectorControls>
                {chooserOpen ? (
                    <>
                        <input
                            type="text"
                            placeholder="Search icons..."
                            value={filter}
                            onChange={e => setFilter(e.target.value)}
                            className="lsx-icons-search"
                            aria-label="Search icons"
                            autoComplete="off"
                        />
                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '8px', maxHeight: 200, overflowY: 'auto', border: '1px solid #eee', padding: 8, fontSize: '1rem' }}>
                            {filteredIconList.map(name => {
                                const IconComponent = icons[localType][name];
                                return (
                                    <div
                                        key={name}
                                        style={{ outline: localName === name ? '2px solid #8B5CF6' : '1px solid #ccc', borderRadius: 4, padding: 4, cursor: 'pointer', background: localName === name ? '#f3f4f6' : 'white' }}
                                        onClick={() => updateName(name)}
                                        title={name}
                                    >
                                        <span>
                                            <IconComponent width={32} height={32} />
                                        </span>
                                    </div>
                                );
                            })}
                        </div>
                        <div style={{ padding: '16px 0', textAlign: 'center' }}>
                            <div
                                className="block-icon-svg"
                            >
                                {(() => {
                                    const IconComponent = icons[localType]?.[localName];
                                    if (!IconComponent) return null;
                                    try {
                                        return <IconComponent />;
                                    } catch (error) {
                                        console.error(`Error rendering icon ${localType}/${localName}:`, error);
                                        return <span>Icon rendering failed</span>;
                                    }
                                })()}
                            </div>
                            <button type="button" style={{ display: 'block', margin: '12px auto', padding: '6px 16px', background: '#8B5CF6', color: 'white', border: 'none', borderRadius: 4, cursor: 'pointer' }} onClick={handleInsert}>Insert</button>
                        </div>
                    </>
                ) : (
                    <div style={{ textAlign: 'center', cursor: isSelected ? 'pointer' : 'default' }} onClick={isSelected ? handleEdit : undefined}>
                        <div
                            className="block-icon-svg"
                            style={{ fontSize: 'inherit', display: 'inline-block' }}
                        >
                            {localName && icons[localType][localName] && (
                                (() => {
                                    const IconComponent = icons[localType][localName];
                                    return (
                                        <IconComponent/>
                                    );
                                })()
                            )}
                        </div>
                    </div>
                )}
            </div>
        );
    },
    save: (props) => {
        const { attributes } = props;
        const { iconType, iconName } = attributes;
        if (!iconName) return null;
        const IconComponent = icons[iconType][iconName];
        return (
            <div {...useBlockProps.save()}>
                <span
                    className="block-icon-svg"
                    style={{ fontSize: 'inherit', display: 'inline-block' }}
                >
                    {IconComponent && (
                        <IconComponent/>
                    )}
                </span>
            </div>
        );
    }
})
