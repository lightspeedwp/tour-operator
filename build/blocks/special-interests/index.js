/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/conditional-block-registration.js":
/*!**************************************************!*\
  !*** ./src/js/conditional-block-registration.js ***!
  \**************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   createConditionalRegistration: function() { return /* binding */ createConditionalRegistration; },
/* harmony export */   registerForPostTypes: function() { return /* binding */ registerForPostTypes; },
/* harmony export */   registerForPostTypesAndTemplates: function() { return /* binding */ registerForPostTypesAndTemplates; },
/* harmony export */   registerForTemplates: function() { return /* binding */ registerForTemplates; }
/* harmony export */ });
/**
 * Conditional Block Registration Utility
 *
 * Provides a unified way to conditionally register WordPress block variations
 * based on post types and template slugs.
 */

/**
 * Creates a conditional block registration handler
 *
 * @param {Object} config - Configuration object
 * @param {string[]} config.postTypes - Array of post types that support the block
 * @param {string[]} config.templateSlugs - Array of template slug patterns to match
 * @param {Function} config.registerFunction - Function to call when conditions are met
 * @param {number} [config.timeout=100] - Initial timeout before checking registration
 *
 * @return {Function} A function that handles the conditional registration logic
 */
function createConditionalRegistration(config) {
  const {
    postTypes = [],
    templateSlugs = [],
    registerFunction,
    timeout = 100
  } = config;
  if (!registerFunction || typeof registerFunction !== 'function') {
    throw new Error('registerFunction is required and must be a function');
  }
  return function conditionallyRegister() {
    const {
      select
    } = wp.data;
    let registered = false;
    let checking = false;

    /**
     * Check if current context matches the registration criteria
     *
     * @return {boolean} True if block should be registered
     */
    const shouldRegister = () => {
      try {
        const postType = select('core/editor')?.getCurrentPostType();
        const postSlug = select('core/editor')?.getEditedPostSlug();
        if (!postType) {
          return false;
        }

        // Check direct post type match
        if (postTypes.includes(postType)) {
          return true;
        }

        // Check template context
        const isTemplateContext = postType === 'wp_template' || postType === 'wp_template_part';
        if (isTemplateContext && postSlug && templateSlugs.length > 0) {
          return templateSlugs.some(slugPattern => {
            if (typeof slugPattern === 'string') {
              return postSlug.includes(slugPattern);
            }
            if (slugPattern instanceof RegExp) {
              return slugPattern.test(postSlug);
            }
            return false;
          });
        }
        return false;
      } catch (error) {
        console.error('Error in shouldRegister:', error);
        return false;
      }
    };

    /**
     * Attempt to register the block if conditions are met
     *
     * @return {boolean} True if registration was successful
     */
    const checkAndRegister = () => {
      if (registered || checking) {
        return registered;
      }
      checking = true;
      if (shouldRegister()) {
        try {
          registerFunction();
          registered = true;
          checking = false;
          return true;
        } catch (error) {
          console.error('Error during block registration:', error);
          checking = false;
          return false;
        }
      }
      checking = false;
      return false;
    };

    // Try initial registration with timeout
    setTimeout(() => {
      if (!checkAndRegister()) {
        // Subscribe to editor changes if initial check failed
        let unsubscribed = false;
        const unsubscribe = wp.data.subscribe(() => {
          if (unsubscribed) {
            return;
          }
          if (checkAndRegister()) {
            unsubscribed = true;
            unsubscribe();
          }
        });
      }
    }, timeout);
  };
}

/**
 * Simplified registration for blocks that only support specific post types
 *
 * @param {string[]} postTypes - Array of supported post types
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
function registerForPostTypes(postTypes, registerFunction, options = {}) {
  return createConditionalRegistration({
    postTypes,
    registerFunction,
    ...options
  });
}

/**
 * Simplified registration for blocks that support templates with specific slug patterns
 *
 * @param {string[]} templateSlugs - Array of template slug patterns
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
function registerForTemplates(templateSlugs, registerFunction, options = {}) {
  return createConditionalRegistration({
    templateSlugs,
    registerFunction,
    ...options
  });
}

/**
 * Registration for blocks that support both post types and template patterns
 *
 * @param {string[]} postTypes - Array of supported post types
 * @param {string[]} templateSlugs - Array of template slug patterns
 * @param {Function} registerFunction - Function to call for registration
 * @param {Object} options - Additional options
 *
 * @return {Function} Registration handler function
 */
function registerForPostTypesAndTemplates(postTypes, templateSlugs, registerFunction, options = {}) {
  return createConditionalRegistration({
    postTypes,
    templateSlugs,
    registerFunction,
    ...options
  });
}

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

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
/*!***********************************************!*\
  !*** ./src/blocks/special-interests/index.js ***!
  \***********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @utils/conditional-block-registration.js */ "./src/js/conditional-block-registration.js");


wp.domReady(() => {
  // Register variation function
  const registerSpecialInterestsVariation = () => {
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/special-interests',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Special Interests', 'tour-operator'),
      description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Display special interests and activities for accommodations.', 'tour-operator'),
      icon: wp.element.createElement('svg', {
        width: 21,
        height: 20,
        viewBox: '0 0 21 20',
        fill: 'none',
        xmlns: 'http://www.w3.org/2000/svg'
      }, wp.element.createElement('g', {
        'clip-path': 'url(#clip0_10031_118612)'
      }, wp.element.createElement('path', {
        d: 'M11.3238 14.3638H9.67638C9.64222 14.4227 9.56361 14.5612 9.48501 14.7033C8.26485 16.8302 5.50328 17.4641 3.52093 16.0716C1.52835 14.6687 1.17632 11.8663 2.67332 9.92294C3.27485 9.14008 3.71916 8.23249 4.20791 7.36652C4.57704 6.71182 5.06919 6.21645 5.73224 5.87351C5.8758 5.78692 5.98517 5.65529 6.03984 5.49595C6.36795 4.4706 7.26 3.9302 8.23065 4.19001C9.17058 4.44289 9.65247 5.35044 9.48157 6.3931C9.44056 6.63559 9.66955 6.91965 9.76867 7.18636C9.88147 7.49468 10.0865 7.53278 10.3976 7.56743C11.1836 7.65054 11.2725 7.0201 11.4912 6.61136C11.5664 6.47281 11.5049 6.38618 11.4878 6.27881C11.2657 4.96596 11.7237 4.48791 12.6533 4.20386C13.6103 3.91289 14.5536 4.44981 14.8886 5.4405C14.9432 5.6068 15.1004 5.78345 15.2577 5.86659C15.8695 6.19566 16.3514 6.63906 16.7102 7.2418C17.3254 8.27754 17.9543 9.30633 18.5934 10.3282C19.8307 12.2993 19.2702 14.9215 17.3254 16.1582C15.3841 17.3983 12.8174 16.8059 11.5938 14.8349C11.5903 14.828 11.587 14.8245 11.5835 14.8176C11.481 14.6548 11.3887 14.4816 11.3238 14.3638ZM8.55537 12.6353C8.57245 11.1353 7.38645 9.90216 5.90657 9.88137C4.45059 9.86058 3.19966 11.0903 3.17573 12.5729C3.15181 14.0763 4.37538 15.3337 5.86555 15.3372C7.35572 15.3441 8.54512 14.1525 8.55537 12.6353ZM17.7971 12.611C17.7971 11.118 16.5872 9.88832 15.1209 9.88137C13.6581 9.87445 12.4346 11.1007 12.4107 12.5937C12.3901 14.0936 13.6239 15.3407 15.1244 15.3372C16.6043 15.3337 17.8005 14.1144 17.7971 12.611ZM10.4249 12.029C10.1241 12.0533 9.93957 12.2611 9.91906 12.6041C9.90198 12.9089 10.131 13.1722 10.4351 13.193H10.5103C10.8556 13.1722 11.0538 12.9782 11.064 12.618C11.0709 12.2646 10.8214 12.0221 10.4249 12.029Z',
        fill: 'currentColor'
      })), wp.element.createElement('defs', null, wp.element.createElement('clipPath', {
        id: 'clip0_10031_118612'
      }, wp.element.createElement('rect', {
        width: 17.5,
        height: 17.5,
        fill: 'white',
        transform: 'translate(1.75 1.5)'
      })))),
      category: 'lsx-tour-operator',
      keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('special', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('interests', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('activities', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('features', 'tour-operator')],
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.className === variationAttributes.className;
      },
      attributes: {
        metadata: {
          name: 'Special Interests'
        },
        className: 'lsx-special-interests-wrapper',
        layout: {
          type: 'constrained'
        }
      },
      innerBlocks: [['core/group', {
        metadata: {
          name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Title', 'tour-operator')
        },
        layout: {
          type: 'flex',
          flexWrap: 'nowrap',
          verticalAlignment: 'middle'
        }
      }, [['lsx-tour-operator/icons', {
        iconType: 'solid',
        iconName: 'specialInterestsIcon'
      }], ['core/paragraph', {
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Special Interests:', 'tour-operator') + '</strong>'
      }]]], ['core/group', {
        metadata: {
          name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Interests Content', 'tour-operator')
        },
        layout: {
          type: 'flex',
          flexWrap: 'nowrap'
        }
      }, [['core/paragraph', {
        metadata: {
          bindings: {
            content: {
              source: 'lsx/post-meta',
              args: {
                key: 'special_interests'
              }
            }
          }
        }
      }]]]],
      supports: {
        renaming: false
      },
      example: {
        attributes: {
          className: 'lsx-special-interests-wrapper'
        },
        innerBlocks: [{
          name: 'core/group',
          attributes: {
            layout: {
              type: 'flex',
              flexWrap: 'nowrap',
              verticalAlignment: 'middle'
            }
          },
          innerBlocks: [{
            name: 'lsx-tour-operator/icons',
            attributes: {
              iconType: 'solid',
              iconName: 'specialInterestsIcon'
            }
          }, {
            name: 'core/paragraph',
            attributes: {
              content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Special Interests:', 'tour-operator') + '</strong>'
            }
          }]
        }, {
          name: 'core/group',
          attributes: {
            layout: {
              type: 'flex',
              flexWrap: 'nowrap'
            }
          },
          innerBlocks: [{
            name: 'core/paragraph',
            attributes: {
              content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Wildlife viewing, Photography, Cultural experiences, Adventure activities', 'tour-operator')
            }
          }]
        }]
      }
    });
  };

  // Initialize conditional registration for accommodation context
  const conditionalRegister = (0,_utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__.registerForPostTypesAndTemplates)(['accommodation'],
  // Supported post types
  ['accommodation'],
  // Template slug patterns
  registerSpecialInterestsVariation);
  conditionalRegister();
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map