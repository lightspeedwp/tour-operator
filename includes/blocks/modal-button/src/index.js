import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	BlockControls,
	AlignmentToolbar
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	Spinner
} from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

const modalButtonIcon = (
	<svg fill="none" height="15" viewBox="0 0 15 15" width="15" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M2 5H13C13.5523 5 14 5.44772 14 6V9C14 9.55228 13.5523 10 13 10H2C1.44772 10 1 9.55228 1 9V6C1 5.44772 1.44772 5 2 5ZM0 6C0 4.89543 0.895431 4 2 4H13C14.1046 4 15 4.89543 15 6V9C15 10.1046 14.1046 11 13 11H2C0.89543 11 0 10.1046 0 9V6ZM4.5 6.75C4.08579 6.75 3.75 7.08579 3.75 7.5C3.75 7.91421 4.08579 8.25 4.5 8.25C4.91421 8.25 5.25 7.91421 5.25 7.5C5.25 7.08579 4.91421 6.75 4.5 6.75ZM6.75 7.5C6.75 7.08579 7.08579 6.75 7.5 6.75C7.91421 6.75 8.25 7.08579 8.25 7.5C8.25 7.91421 7.91421 8.25 7.5 8.25C7.08579 8.25 6.75 7.91421 6.75 7.5ZM10.5 6.75C10.0858 6.75 9.75 7.08579 9.75 7.5C9.75 7.91421 10.0858 8.25 10.5 8.25C10.9142 8.25 11.25 7.91421 11.25 7.5C11.25 7.08579 10.9142 6.75 10.5 6.75Z" fill="currentColor" fill-rule="evenodd"/></svg>
);

registerBlockType('lsx-tour-operator/modal-button', {
	icon: modalButtonIcon,
	edit: ({ attributes, setAttributes }) => {
		const { text, modalId, align } = attributes;
		const [modalOptions, setModalOptions] = useState([]);
		const [isLoading, setIsLoading] = useState(true);

		const blockProps = useBlockProps({
			className: `wp-block-button has-text-align-${align}`
		});

		// Fetch modal options from the REST API
		useEffect(() => {
			const fetchModalOptions = async () => {
				try {
					setIsLoading(true);
					const options = await apiFetch({
						path: '/tour-operator/v1/modal-options'
					});
					setModalOptions(options);
				} catch (error) {
					console.error('Failed to fetch modal options:', error);
					setModalOptions([
						{ label: __('Select a modal...', 'tour-operator'), value: '' },
						{ label: __('No modals found', 'tour-operator'), value: '', disabled: true }
					]);
				} finally {
					setIsLoading(false);
				}
			};

			fetchModalOptions();
		}, []);

		return (
			<>
				<BlockControls>
					<AlignmentToolbar
						value={align}
						onChange={(newAlign) => setAttributes({ align: newAlign })}
					/>
				</BlockControls>

				<InspectorControls>
					<PanelBody title={__('Modal Settings', 'tour-operator')}>
						{isLoading ? (
							<div style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
								<Spinner />
								<span>{__('Loading modal options...', 'tour-operator')}</span>
							</div>
						) : (
							<SelectControl
								label={__('Modal to Open', 'tour-operator')}
								value={modalId}
								options={modalOptions}
								onChange={(newModalId) => setAttributes({ modalId: newModalId })}
								help={__('Select which modal template should open when this button is clicked. These are filtered from the lsx_to_modals template part area.', 'tour-operator')}
							/>
						)}
					</PanelBody>
				</InspectorControls>

				<div {...blockProps}>
					<div className={`wp-block-button__link`}>
						<RichText
							tagName="span"
							value={text}
							onChange={(newText) => setAttributes({ text: newText })}
							placeholder={__('Add button text...', 'tour-operator')}
							allowedFormats={[]}
						/>
					</div>
					{!modalId && !isLoading && (
						<div className="block-editor-warning">
							{__('Please select a modal in the block settings.', 'tour-operator')}
						</div>
					)}
				</div>
			</>
		);
	},

	save: ({ attributes }) => {
		const { text, modalId, align } = attributes;
		const blockProps = useBlockProps.save({
			className: `wp-block-button has-text-align-${align}`
		});

		if (!modalId) {
			return null;
		}

		return (
			<div {...blockProps}>
				<a
					className={`wp-block-button__link`}
					href={`#to-modal-${modalId}`}
					type="button"
				>
					{text}
				</a>
			</div>
		);
	}
});
