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
/*!*************************************!*\
  !*** ./src/blocks/climate/index.js ***!
  \*************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @utils/conditional-block-registration.js */ "./src/js/conditional-block-registration.js");


wp.domReady(() => {
  // Register variation function
  const registerClimateVariation = () => {
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/climate',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Climate', 'tour-operator'),
      description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Display climate and weather information for destinations.', 'tour-operator'),
      icon: wp.element.createElement('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        width: 20,
        height: 20,
        viewBox: '0 0 20 20',
        fill: 'none'
      }, wp.element.createElement('path', {
        d: 'M15.175 1.5371C15.3281 1.5996 15.4406 1.7371 15.4719 1.8996L16 4.4996L18.6 5.0246C18.7625 5.05897 18.8969 5.16835 18.9625 5.32147C19.0281 5.4746 19.0094 5.6496 18.9188 5.7871L17.4531 7.99647L18.9188 10.2058C19.0094 10.3433 19.0281 10.5183 18.9625 10.6715C18.8969 10.8246 18.7625 10.9371 18.6 10.9683L16.6562 11.3652C16.2844 11.0933 15.8719 10.8777 15.425 10.7277C15.3469 10.3308 15.2125 9.95585 15.0281 9.6121C15.325 9.14647 15.5 8.59335 15.5 7.99647C15.5 6.34022 14.1562 4.99647 12.5 4.99647C11.0031 4.99647 9.7625 6.09335 9.5375 7.5246C8.70938 6.89022 7.67813 6.50897 6.55625 6.49647L6.08437 5.7871C5.99375 5.6496 5.975 5.4746 6.04063 5.32147C6.10625 5.16835 6.24062 5.05585 6.40312 5.0246L9 4.4996L9.525 1.8996C9.55937 1.7371 9.66875 1.60272 9.82187 1.5371C9.975 1.47147 10.15 1.49022 10.2875 1.58085L12.5 3.0496L14.7094 1.58397C14.8469 1.49335 15.0219 1.4746 15.175 1.54022V1.5371ZM14 7.9996C14 8.11835 13.9875 8.23397 13.9594 8.34647C13.2812 7.81522 12.4281 7.4996 11.5 7.4996C11.3562 7.4996 11.2156 7.50585 11.0781 7.52147C11.2781 6.92772 11.8406 6.4996 12.5 6.4996C13.3281 6.4996 14 7.17147 14 7.9996ZM4 17.9996C2.34375 17.9996 1 16.6558 1 14.9996C1 13.6715 1.8625 12.5433 3.05938 12.1496C3.01875 11.9402 3 11.7215 3 11.4996C3 9.56522 4.56562 7.9996 6.5 7.9996C7.84688 7.9996 9.01562 8.75897 9.6 9.8746C10.0594 9.34022 10.7406 8.9996 11.5 8.9996C12.8813 8.9996 14 10.1183 14 11.4996C14 11.6715 13.9812 11.8371 13.95 11.9996C13.9656 11.9996 13.9844 11.9996 14 11.9996C15.6562 11.9996 17 13.3433 17 14.9996C17 16.6558 15.6562 17.9996 14 17.9996H4Z',
        fill: '#currentColor'
      })),
      category: 'lsx-tour-operator',
      keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('climate', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('weather', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('temperature', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('season', 'tour-operator')],
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.metadata?.className === variationAttributes.metadata?.className;
      },
      attributes: {
        metadata: {
          name: 'Climate'
        },
        className: 'lsx-climate-wrapper',
        layout: {
          type: 'constrained'
        }
      },
      innerBlocks: [['core/group', {
        layout: {
          type: 'constrained'
        }
      }, [['core/group', {
        layout: {
          type: 'constrained'
        }
      }, [['core/paragraph', {
        align: 'center',
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Climate', 'tour-operator') + '</strong>'
      }]]], ['core/group', {
        layout: {
          type: 'constrained'
        }
      }, [['core/paragraph', {
        metadata: {
          bindings: {
            content: {
              source: 'lsx/post-meta',
              args: {
                key: 'climate'
              }
            }
          }
        },
        content: ''
      }]]]]], ['core/buttons', {}, [['core/button', {
        backgroundColor: 'primary',
        width: 100,
        text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('View More', 'tour-operator')
      }]]]],
      supports: {
        renaming: false
      },
      example: {
        attributes: {
          className: 'lsx-climate-wrapper'
        },
        innerBlocks: [{
          name: 'core/group',
          attributes: {
            layout: {
              type: 'constrained'
            }
          },
          innerBlocks: [{
            name: 'core/group',
            attributes: {
              layout: {
                type: 'constrained'
              }
            },
            innerBlocks: [{
              name: 'core/paragraph',
              attributes: {
                align: 'center',
                content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Climate', 'tour-operator') + '</strong>'
              }
            }]
          }, {
            name: 'core/group',
            attributes: {
              layout: {
                type: 'constrained'
              }
            },
            innerBlocks: [{
              name: 'core/paragraph',
              attributes: {
                content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Tropical climate with warm temperatures year-round. Dry season from May to October. Average temperature ranges from 24°C to 30°C.', 'tour-operator')
              }
            }]
          }]
        }, {
          name: 'core/buttons',
          attributes: {},
          innerBlocks: [{
            name: 'core/button',
            attributes: {
              backgroundColor: 'primary',
              width: 100,
              text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('View More', 'tour-operator')
            }
          }]
        }]
      }
    });
  };

  // Initialize conditional registration
  const conditionalRegister = (0,_utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__.registerForPostTypesAndTemplates)(['destination'],
  // Supported post types
  ['destination'],
  // Template slug patterns
  registerClimateVariation);
  conditionalRegister();
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map