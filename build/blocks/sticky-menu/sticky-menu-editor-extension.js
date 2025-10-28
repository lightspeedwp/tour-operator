/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ (function(module) {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["compose"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/hooks":
/*!*******************************!*\
  !*** external ["wp","hooks"] ***!
  \*******************************/
/***/ (function(module) {

module.exports = window["wp"]["hooks"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["ReactJSXRuntime"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
!function() {
/*!****************************************************************!*\
  !*** ./src/blocks/sticky-menu/sticky-menu-editor-extension.js ***!
  \****************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/hooks */ "@wordpress/hooks");
/* harmony import */ var _wordpress_hooks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__);
/**
 * Sticky Menu Editor Extensions
 *
 * Extends the core/group block with sticky menu functionality
 * by adding custom attributes, inspector controls, and visual indicators.
 *
 * @package Tour_Operator
 * @subpackage Blocks
 * @since 2.1.0
 */

/**
 * WordPress dependencies
 */








/**
 * Add sticky menu attributes to core/group block.
 *
 * Extends the core/group block with attributes needed for
 * sticky menu functionality.
 *
 * @since 2.1.0
 * @param {Object} settings Block registration settings.
 * @param {string} name Block name.
 * @return {Object} Modified block settings.
 */

function addStickyMenuAttributes(settings, name) {
  if (name !== 'core/group') {
    return settings;
  }
  return {
    ...settings,
    attributes: {
      ...settings.attributes,
      addToStickyMenu: {
        type: 'boolean',
        default: false
      },
      stickyMenuId: {
        type: 'string',
        default: ''
      },
      stickyMenuTitle: {
        type: 'string',
        default: ''
      }
    }
  };
}
(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.addFilter)('blocks.registerBlockType', 'lsx-tour-operator/add-sticky-menu-attributes', addStickyMenuAttributes);

/**
 * Add sticky menu controls to core/group block.
 *
 * Creates a higher-order component that adds sticky menu configuration
 * controls to the inspector panel of core/group blocks.
 *
 * @since 2.1.0
 * @param {Function} BlockEdit The original block edit component.
 * @return {Function} Enhanced block edit component with sticky menu controls.
 */
const withStickyMenuControls = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__.createHigherOrderComponent)(BlockEdit => {
  return props => {
    const {
      attributes,
      setAttributes,
      name
    } = props;
    if (name !== 'core/group') {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(BlockEdit, {
        ...props
      });
    }

    // Check if there's a sticky-menu block in the editor
    const hasStickyMenuBlock = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.useSelect)(select => {
      const {
        getBlocks
      } = select('core/block-editor');

      // Recursively check all blocks and their inner blocks
      const checkBlocksForStickyMenu = blocks => {
        return blocks.some(block => {
          if (block.name === 'lsx-tour-operator/sticky-menu') {
            return true;
          }
          // Check inner blocks recursively
          if (block.innerBlocks && block.innerBlocks.length > 0) {
            return checkBlocksForStickyMenu(block.innerBlocks);
          }
          return false;
        });
      };
      const allBlocks = getBlocks();
      return checkBlocksForStickyMenu(allBlocks);
    }, []);
    const {
      addToStickyMenu,
      stickyMenuId,
      stickyMenuTitle
    } = attributes;

    // Local state for the CSS ID input to prevent focus loss
    const [localStickyMenuId, setLocalStickyMenuId] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useState)(stickyMenuId || '');

    // Sync local state with attributes when attributes change externally
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useEffect)(() => {
      setLocalStickyMenuId(stickyMenuId || '');
    }, [stickyMenuId]);

    // Clear sticky menu data when no sticky menu block is present
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useEffect)(() => {
      if (!hasStickyMenuBlock && addToStickyMenu) {
        setAttributes({
          addToStickyMenu: false,
          stickyMenuId: '',
          stickyMenuTitle: ''
        });
      }
    }, [hasStickyMenuBlock, addToStickyMenu, setAttributes]);

    // Don't show controls if no sticky menu block is present
    if (!hasStickyMenuBlock) {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(BlockEdit, {
        ...props
      });
    }
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsxs)(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.Fragment, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(BlockEdit, {
        ...props
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Sticky Menu Settings', 'tour-operator'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ToggleControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Add to Sticky Menu', 'tour-operator'),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Include this section in the sticky navigation menu', 'tour-operator'),
            checked: addToStickyMenu,
            onChange: value => {
              setAttributes({
                addToStickyMenu: value
              });

              // If disabled, clear the other fields
              if (!value) {
                setAttributes({
                  stickyMenuId: '',
                  stickyMenuTitle: ''
                });
              }
            }
          }), addToStickyMenu && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsxs)(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.Fragment, {
            children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('CSS ID', 'tour-operator'),
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Required: Unique ID for this section (without #)', 'tour-operator'),
              value: localStickyMenuId,
              onChange: value => {
                // Update local state immediately for smooth typing
                setLocalStickyMenuId(value);
              },
              onBlur: () => {
                // Clean and save to attributes when user finishes typing
                const cleanId = localStickyMenuId.replace(/[^a-zA-Z0-9-_]/g, '').toLowerCase();
                setLocalStickyMenuId(cleanId);
                setAttributes({
                  stickyMenuId: cleanId
                });
              },
              placeholder: "section-id"
            }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.TextControl, {
              label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Menu Title', 'tour-operator'),
              help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Title to display in the sticky menu', 'tour-operator'),
              value: stickyMenuTitle,
              onChange: value => setAttributes({
                stickyMenuTitle: value
              }),
              placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Section Title', 'tour-operator')
            })]
          })]
        })
      })]
    });
  };
}, 'withStickyMenuControls');
(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.addFilter)('editor.BlockEdit', 'lsx-tour-operator/with-sticky-menu-controls', withStickyMenuControls);

/**
 * Add sticky menu attributes to block save props.
 *
 * Modifies the saved HTML attributes for group blocks that have
 * sticky menu functionality enabled. Adds necessary data attributes
 * and accessibility properties.
 *
 * Note: This runs during save and doesn't need to check for sticky menu block presence
 * since the attributes will be cleared by the editor when no sticky menu block exists.
 *
 * @since 2.1.0
 * @param {Object} extraProps Additional props to add to the block wrapper.
 * @param {Object} blockType Block type definition.
 * @param {Object} attributes Block attributes.
 * @return {Object} Modified extra props.
 */
function addStickyMenuSaveProps(extraProps, blockType, attributes) {
  if (blockType.name !== 'core/group') {
    return extraProps;
  }
  const {
    addToStickyMenu,
    stickyMenuId,
    stickyMenuTitle
  } = attributes;
  if (addToStickyMenu && stickyMenuId) {
    extraProps.id = stickyMenuId;
    extraProps['data-sticky-menu-section'] = 'true';
    extraProps['data-section-title'] = stickyMenuTitle || stickyMenuId;

    // Add ARIA attributes for accessibility
    extraProps.role = 'region';
    extraProps['aria-labelledby'] = `${stickyMenuId}-header`;

    // Add custom CSS class for frontend styling/JavaScript targeting
    const existingClass = extraProps.className || '';
    extraProps.className = `${existingClass} lsx-to-sticky-menu-section`.trim();
  }
  return extraProps;
}
(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.addFilter)('blocks.getSaveContent.extraProps', 'lsx-tour-operator/add-sticky-menu-save-props', addStickyMenuSaveProps);

/**
 * Add visual indicator in editor for sticky menu sections.
 *
 * Creates a higher-order component that adds visual styling and badges
 * to group blocks that are part of the sticky menu system.
 *
 * @since 2.1.0
 * @param {Function} BlockListBlock The original block list block component.
 * @return {Function} Enhanced block list block component with visual indicators.
 */
const withStickyMenuEditor = (0,_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__.createHigherOrderComponent)(BlockListBlock => {
  return props => {
    const {
      attributes,
      name
    } = props;
    if (name !== 'core/group') {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(BlockListBlock, {
        ...props
      });
    }

    // Check if there's a sticky-menu block in the editor
    const hasStickyMenuBlock = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_6__.useSelect)(select => {
      const {
        getBlocks
      } = select('core/block-editor');

      // Recursively check all blocks and their inner blocks
      const checkBlocksForStickyMenu = blocks => {
        return blocks.some(block => {
          if (block.name === 'lsx-tour-operator/sticky-menu') {
            return true;
          }
          // Check inner blocks recursively
          if (block.innerBlocks && block.innerBlocks.length > 0) {
            return checkBlocksForStickyMenu(block.innerBlocks);
          }
          return false;
        });
      };
      const allBlocks = getBlocks();
      return checkBlocksForStickyMenu(allBlocks);
    }, []);
    const {
      addToStickyMenu,
      stickyMenuId,
      stickyMenuTitle
    } = attributes;
    if (!hasStickyMenuBlock || !addToStickyMenu || !stickyMenuId) {
      return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(BlockListBlock, {
        ...props
      });
    }

    // Add a visual indicator in the editor
    const wrapperProps = {
      ...props.wrapperProps,
      style: {
        ...props.wrapperProps?.style,
        border: '2px dashed #007cba',
        position: 'relative'
      }
    };

    // Add a badge to show it's part of sticky menu
    const badge = /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsxs)("div", {
      style: {
        position: 'absolute',
        top: '-10px',
        left: '10px',
        background: '#007cba',
        color: 'white',
        padding: '2px 8px',
        fontSize: '11px',
        borderRadius: '3px',
        zIndex: 10,
        fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif'
      },
      children: ["\uD83D\uDCCC ", (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Sticky Menu Section', 'tour-operator'), ": ", stickyMenuTitle || stickyMenuId]
    });
    return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsxs)("div", {
      style: {
        position: 'relative'
      },
      children: [badge, /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_7__.jsx)(BlockListBlock, {
        ...props,
        wrapperProps: wrapperProps
      })]
    });
  };
}, 'withStickyMenuEditor');
(0,_wordpress_hooks__WEBPACK_IMPORTED_MODULE_1__.addFilter)('editor.BlockListBlock', 'lsx-tour-operator/with-sticky-menu-editor', withStickyMenuEditor);
}();
/******/ })()
;
//# sourceMappingURL=sticky-menu-editor-extension.js.map