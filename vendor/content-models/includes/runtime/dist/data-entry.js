(() => {
  "use strict";
  
  const plugins = window.wp.plugins;
  const element = window.wp.element;
  const coreData = window.wp.coreData;
  const data = window.wp.data;
  const blockEditor = window.wp.blockEditor;
  const blocks = window.wp.blocks;
  
  const {
	POST_TYPE,
	FIELDS,
	FALLBACK_VALUE_PLACEHOLDER
  } = window.contentModelData;

  // Function to serialize inner blocks
  const serializeInnerBlocks = (blocks, metadata = {}) => {
	for (const block of blocks) {
	  if ("core/group" !== block.name) continue;
	  
	  const key = block.attributes.metadata?.bindings?.content?.args?.key;
	  
	  if (key && "post_content" !== key) {
		metadata[key] = blocks.serialize(block.innerBlocks);
	  }
	  
	  if (block.innerBlocks.length > 0) {
		metadata = serializeInnerBlocks(block.innerBlocks, metadata);
	  }
	}
	return metadata;
  };
  
  // List of supported block types with their respective attributes
  const supportedBlockTypes = Object.keys({
	"core/group": ["content"],
	"core/paragraph": ["content"],
	"core/heading": ["content"],
	"core/image": ["id", "url", "title", "alt"],
	"core/button": ["url", "text", "linkTarget", "rel"]
  });

  // Function to update block editing mode
  const updateBlockEditingMode = (blocks, setBlockEditingMode, recursive = false) => {
	blocks.forEach((block) => {
	  if (block.innerBlocks.length > 0 && block.attributes.metadata?.bindings) {
		setBlockEditingMode(block.clientId, "default");
		
		if (block.innerBlocks) {
		  updateBlockEditingMode(block.innerBlocks, setBlockEditingMode, true);
		}
	  } else if (block.innerBlocks.length > 0) {
		findEditableGroup(block.innerBlocks) || (
		  data.dispatch("core/block-editor").updateBlock(block.clientId, {
			...block,
			attributes: { ...block.attributes, templateLock: "contentOnly" }
		  }),
		  setBlockEditingMode(block.clientId, "disabled")
		);
		
		if (block.innerBlocks) {
		  updateBlockEditingMode(block.innerBlocks, setBlockEditingMode);
		}
	  } else if (
		supportedBlockTypes.includes(block.name) &&
		block.attributes.metadata?.bindings ||
		recursive
	  ) {
		setBlockEditingMode(block.clientId, "");
	  } else {
		setBlockEditingMode(block.clientId, "disabled");
	  }
	});
  };

  // Recursive function to find an editable group block
  const findEditableGroup = (blocks) => {
	for (const block of blocks) {
	  if ("core/group" === block.name && block.attributes.metadata?.bindings) {
		return block;
	  }
	  
	  if (block.innerBlocks.length > 0) {
		const foundBlock = findEditableGroup(block.innerBlocks);
		if (foundBlock) return foundBlock;
	  }
	}
	
	return null;
  };

  const React = window.React;
  const editor = window.wp.editor;
  const components = window.wp.components;
  const i18n = window.wp.i18n;

  // UI Components
  const FieldsUI = ({ fields }) => (
	React.createElement(components.__experimentalVStack, null,
	  fields.filter(field => field.visible).map(field =>
		React.createElement(Field, { key: field.slug, field })
	  )
	)
  );

  const Field = ({ field }) => {
	const [meta, setMeta] = coreData.useEntityProp("postType", POST_TYPE, "meta");
	const value = meta[field.slug] !== null && meta[field.slug] !== undefined ? meta[field.slug] : '';
	return React.createElement("div", null,
	  React.createElement(FieldInput, {
		field,
		value,
		saveChanges: (slug, newValue) => { console.log(slug);console.log(newValue); setMeta({ [slug]: newValue }); }
	  }),
	  React.createElement("small", null, React.createElement("em", null, field.description))
	);
  };

  const FieldInput = ({ field, isDisabled = false, value, saveChanges }) => {
	if (field.type === "image") {
	  return React.createElement(React.Fragment, null,
		React.createElement("span", {
		  style: {
			textTransform: "uppercase",
			fontSize: "11px",
			marginBottom: "calc(8px)",
			fontWeight: "500"
		  }
		}, field.label),
		!value && React.createElement(blockEditor.MediaPlaceholder, {
		  allowedTypes: ["image"],
		  accept: "image",
		  multiple: false,
		  onSelect: (media) => saveChanges(field.slug, media.url)
		}),
		value && React.createElement(components.Card, null,
		  React.createElement(components.CardBody, null,
			React.createElement("img", { src: value, alt: field.label, style: { width: "100%" } })
		  ),
		  React.createElement(components.CardFooter, null,
			React.createElement(components.Button, {
			  isDestructive: true,
			  onClick: () => saveChanges(field.slug, "")
			}, i18n.__("Remove Image"))
		  )
		)
	  );
	}

	if (field.type === "textarea") {
	  return React.createElement(components.TextareaControl, {
		label: field.label,
		readOnly: isDisabled,
		value,
		onChange: (newValue) => saveChanges(field.slug, newValue)
	  });
	}

	if (field.type === "multiselect") {
		return React.createElement(components.SelectControl, {
			multiple: true,
			label: field.label,
			readOnly: isDisabled,
			//selectedValues: value, // Assuming `value` is an array of selected values
			value,
			options: field.options, // Assuming `field.options` contains the available options
			onChange: (selectedOptions ) => saveChanges(field.slug, selectedOptions),
		});
	}

	if (field.type === "select") {
		return React.createElement(components.ComboboxControl, {
			//multiple: true,
			label: field.label,
			readOnly: isDisabled,
			//selectedValues: value, // Assuming `value` is an array of selected values
			value,
			options: field.options, // Assuming `field.options` contains the available options
			onChange: (selectedOptions ) => saveChanges(field.slug, selectedOptions),
		});
	}

	return React.createElement(components.TextControl, {
	  label: field.label,
	  type: field.type,
	  readOnly: isDisabled,
	  value,
	  onChange: (newValue) => saveChanges(field.slug, newValue)
	});
  };

  // Registering Plugins
  plugins.registerPlugin("create-content-model-bound-group-extractor", {
	render: () => {
	  (() => {
		const blocks = data.useSelect((select) => select(blockEditor.store).getBlocks());
		const [, setMeta] = coreData.useEntityProp("postType", POST_TYPE, "meta");

		element.useEffect(() => {
		  const metadata = serializeInnerBlocks(blocks);
		  
		  if (Object.keys(metadata).length !== 0) {
			setMeta(metadata);
		  }
		}, [blocks, setMeta]);
	  })();
	}
  });

  plugins.registerPlugin("create-content-model-fields-ui", {
	render: function() {
	  const [isOpen, setOpen] = element.useState(false);
	  console.log( FIELDS );
	  return FIELDS.filter(field => field.visible).length === 0 ? null :
		React.createElement(editor.PluginDocumentSettingPanel, {
		  name: "create-content-model-page-settings",
		  title: i18n.__("Custom Fields"),
		  className: "create-content-model-page-settings"
		},
		React.createElement(components.__experimentalVStack, null,
		  React.createElement(FieldsUI, { fields: FIELDS }),
		  React.createElement(components.Button, {
			variant: "secondary",
			onClick: () => setOpen(true)
		  }, i18n.__("Expand Fields"))
		),
		isOpen && React.createElement(components.Modal, {
		  title: i18n.__("Manage Fields"),
		  size: "large",
		  onRequestClose: () => setOpen(false)
		},
		React.createElement(FieldsUI, { fields: FIELDS })
		)
	  );
	}
  });

  /*plugins.registerPlugin("create-content-model-content-locking", {
	render: () => {
	  (() => {
		const blocks = wp.data.select("core/block-editor").getBlocks();
		const selectedBlock = wp.data.select("core/block-editor").getSelectedBlock();
		const { setBlockEditingMode } = data.useDispatch(blockEditor.store);

		element.useEffect(() => {
		  if (blocks.length > 0) {
			updateBlockEditingMode(blocks, setBlockEditingMode);
		  }
		}, [blocks, setBlockEditingMode, selectedBlock]);
	  })();
	}
  });*/

  plugins.registerPlugin("create-content-model-fallback-value-clearer", {
	render: () => {
	  (() => {
		const [meta, setMeta] = coreData.useEntityProp("postType", POST_TYPE, "meta");
		
		const bindingsMap = data.useSelect((select) => {
		  const blocks = select(blockEditor.store).getBlocks();
		  const map = {};
		  
		  const processBlock = (block) => {
			const bindings = block.attributes?.metadata?.bindings || {};
			
			Object.entries(bindings).forEach(([_, binding]) => {
			  if (binding.source === "core/post-meta") {
				map[block.clientId] || (map[block.clientId] = []);
				map[block.clientId].push({
				  metaKey: binding.args.key,
				  blockName: block.attributes.metadata.name
				});
			  }
			});

			if (block.innerBlocks && block.innerBlocks.length > 0) {
			  block.innerBlocks.forEach(processBlock);
			}
		  };

		  blocks.forEach(processBlock);
		  return map;
		}, []);

		element.useLayoutEffect(() => {
		  Object.entries(bindingsMap).forEach(([, bindings]) => {
			bindings.forEach(({ metaKey }) => {
			  if (meta[metaKey] === FALLBACK_VALUE_PLACEHOLDER) {
				setMeta({ [metaKey]: "" });
			  }
			});
		  });
		}, [meta, setMeta, bindingsMap]);
	  })();
	}
  });

})();
