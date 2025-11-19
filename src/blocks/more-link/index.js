import { __ } from '@wordpress/i18n';

const buttonIcon = (
    <svg
        fill="none"
        height="15"
        viewBox="0 0 15 15"
        width="15"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            clipRule="evenodd"
            d="M2 5H13C13.5523 5 14 5.44772 14 6V9C14 9.55228 13.5523 10 13 10H2C1.44772 10 1 9.55228 1 9V6C1 5.44772 1.44772 5 2 5ZM0 6C0 4.89543 0.895431 4 2 4H13C14.1046 4 15 4.89543 15 6V9C15 10.1046 14.1046 11 13 11H2C0.89543 11 0 10.1046 0 9V6ZM4.5 6.75C4.08579 6.75 3.75 7.08579 3.75 7.5C3.75 7.91421 4.08579 8.25 4.5 8.25C4.91421 8.25 5.25 7.91421 5.25 7.5C5.25 7.08579 4.91421 6.75 4.5 6.75ZM6.75 7.5C6.75 7.08579 7.08579 6.75 7.5 6.75C7.91421 6.75 8.25 7.08579 8.25 7.5C8.25 7.91421 7.91421 8.25 7.5 8.25C7.08579 8.25 6.75 7.91421 6.75 7.5ZM10.5 6.75C10.0858 6.75 9.75 7.08579 9.75 7.5C9.75 7.91421 10.0858 8.25 10.5 8.25C10.9142 8.25 11.25 7.91421 11.25 7.5C11.25 7.08579 10.9142 6.75 10.5 6.75Z"
            fill="currentColor"
            fillRule="evenodd"
        />
    </svg>
);

wp.domReady(() => {
    wp.blocks.registerBlockVariation('core/buttons', {
        name: 'lsx-tour-operator/more-link',
        title: __('More Button', 'tour-operator'),
        icon: buttonIcon,
        category: 'lsx-tour-operator',
        description: __('A button linking to more items in a list or collection.', 'tour-operator'),
        keywords: [
            __('more', 'tour-operator'),
            __('link', 'tour-operator'),
            __('button', 'tour-operator'),
        ],
        isActive: (blockAttributes, variationAttributes) => {
            return blockAttributes.className === variationAttributes.className;
        },
        attributes: {
            metadata: {
                name: __('More Button', 'tour-operator'),
            },
            className: 'lsx-to-more-link-wrapper',
        },
        innerBlocks: [
            [
                'core/button',
                {
                    className: 'lsx-to-more-link more-link',
                    text: __('View More', 'tour-operator'),
                    metadata: {
                        name: __('More Button', 'tour-operator'),
                    },
                }
            ]
        ],
        example: {
            attributes: {
                className: 'lsx-to-more-link more-link',
            },
            innerBlocks: [
                {
                    name: 'core/button',
                    attributes: {
                        className: 'lsx-to-more-link more-link',
                        text: __('View More', 'tour-operator'),
                    },
                },
            ],
        }
    });
});
