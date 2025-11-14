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
  !*** ./src/blocks/minimum-child-age/index.js ***!
  \***********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_conditional_block_registration_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @utils/conditional-block-registration.js */ "./src/js/conditional-block-registration.js");


wp.domReady(() => {
  const registerMinimumChildAgeVariation = () => {
    wp.blocks.registerBlockVariation('core/group', {
      name: 'lsx-tour-operator/minimum-child-age',
      title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Minimum Child Age', 'tour-operator'),
      description: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Display minimum child age requirements for accommodations.', 'tour-operator'),
      icon: wp.element.createElement('svg', {
        width: 21,
        height: 20,
        viewBox: '0 0 21 20',
        fill: 'none',
        xmlns: 'http://www.w3.org/2000/svg'
      }, wp.element.createElement('path', {
        d: 'M4.60997 3.18262C3.22175 3.18262 2.08594 4.31844 2.08594 5.70667C2.08594 7.09487 3.22175 8.23069 4.60997 8.23069C5.9982 8.23069 7.13401 7.09487 7.13401 5.70667C7.13401 4.31844 5.9982 3.18262 4.60997 3.18262Z',
        fill: 'currentColor'
      }), wp.element.createElement('path', {
        d: 'M2.08594 11.7592V16.8224C2.08594 17.2758 2.46454 17.6537 2.91887 17.6537H2.94411C3.39844 17.6537 3.77704 17.2758 3.77704 16.8224V15.966C3.77704 15.5125 4.15565 15.1347 4.60997 15.1347C5.06429 15.1347 5.4429 15.5125 5.4429 15.966V16.8224C5.4429 17.2758 5.8215 17.6537 6.27583 17.6537H6.30108C6.75541 17.6537 7.13401 17.2758 7.13401 16.8224V11.7592C7.13401 10.3738 5.9982 9.24023 4.60997 9.24023H4.58473C3.22175 9.26544 2.08594 10.3738 2.08594 11.7592Z',
        fill: 'currentColor'
      }), wp.element.createElement('path', {
        d: 'M9.72493 6.66577L9.85158 6.792C10.1302 7.06963 10.5356 7.09488 10.8396 6.86772C10.8649 6.84247 10.9155 6.81721 10.9409 6.792C11.2955 6.53958 11.8275 6.6153 12.0302 6.99391C12.4608 7.72586 13.2715 8.23069 14.2088 8.23069C15.1461 8.23069 15.9567 7.72586 16.3874 6.99391C16.6154 6.6153 17.122 6.53958 17.4767 6.792C17.502 6.81721 17.5527 6.84247 17.578 6.86772C17.882 7.09488 18.3127 7.06963 18.566 6.792L18.6926 6.66577C19.0219 6.33767 18.9713 5.80763 18.6166 5.52996C17.9833 5.05042 17.2993 4.67181 16.5647 4.41939C16.4127 4.36891 16.286 4.29319 16.1847 4.16699C15.7287 3.56122 14.9941 3.18262 14.1834 3.18262C13.3728 3.18262 12.6381 3.58646 12.1822 4.16699C12.0809 4.29319 11.9542 4.36891 11.8022 4.41939C11.0675 4.67181 10.3836 5.05042 9.75024 5.52996C9.42094 5.80763 9.3956 6.31242 9.72493 6.66577Z',
        fill: 'currentColor'
      }), wp.element.createElement('path', {
        d: 'M10.5084 15.9609H12.2168C12.3927 15.9609 12.5435 16.1125 12.5435 16.2894V16.7189C12.5435 17.2242 12.9454 17.6537 13.473 17.6537H14.9805C15.483 17.6537 15.9101 17.2494 15.9101 16.7189V16.2894C15.9101 16.1125 16.0608 15.9609 16.2367 15.9609H17.8949C18.1461 15.9609 18.2969 15.7082 18.2215 15.5061L16.4628 10.8067C16.1111 9.84661 15.2066 9.24023 14.2017 9.24023C13.1967 9.24023 12.2922 9.87185 11.9405 10.8067L10.1818 15.5061C10.1064 15.7082 10.2823 15.9609 10.5084 15.9609Z',
        fill: 'currentColor'
      })),
      category: 'lsx-tour-operator',
      keywords: [(0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('minimum', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('child', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('age', 'tour-operator'), (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('requirements', 'tour-operator')],
      isActive: (blockAttributes, variationAttributes) => {
        return blockAttributes.className === variationAttributes.className;
      },
      attributes: {
        metadata: {
          name: 'Minimum Child Age'
        },
        className: 'lsx-minimum-child-age-wrapper',
        layout: {
          type: 'flex',
          flexWrap: 'nowrap'
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
        iconName: 'minimumChildAgeIcon'
      }], ['core/paragraph', {
        content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Minimum Child Age:', 'tour-operator') + '</strong>'
      }]]], ['core/group', {
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
                key: 'minimum_child_age'
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
          className: 'lsx-minimum-child-age-wrapper',
          layout: {
            type: 'flex',
            flexWrap: 'nowrap'
          }
        },
        innerBlocks: [{
          name: 'core/group',
          attributes: {
            metadata: {
              name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Title', 'tour-operator')
            },
            layout: {
              type: 'flex',
              flexWrap: 'nowrap',
              verticalAlignment: 'top'
            }
          },
          innerBlocks: [{
            name: 'lsx-tour-operator/icons',
            attributes: {
              iconType: 'solid',
              iconName: 'minimumChildAgeIcon'
            }
          }, {
            name: 'core/paragraph',
            attributes: {
              content: '<strong>' + (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Minimum Child Age:', 'tour-operator') + '</strong>'
            }
          }]
        }, {
          name: 'core/group',
          attributes: {
            metadata: {
              name: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('Age Content', 'tour-operator')
            },
            layout: {
              type: 'flex',
              flexWrap: 'nowrap'
            }
          },
          innerBlocks: [{
            name: 'core/paragraph',
            attributes: {
              content: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__.__)('12 years old', 'tour-operator')
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
  registerMinimumChildAgeVariation);
  conditionalRegister();
});
}();
/******/ })()
;
//# sourceMappingURL=index.js.map