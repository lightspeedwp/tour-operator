/******/ (function() { // webpackBootstrap
/*!*****************************************************************!*\
  !*** ./src/blocks/accommodation-related-accommodation/index.js ***!
  \*****************************************************************/
wp.domReady(() => {
  const {
    __
  } = wp.i18n;
  wp.blocks.registerBlockVariation('core/group', {
    name: 'lsx-tour-operator/accommodation-related-accommodation',
    title: __('Related accommodation - accommodation', 'tour-operator'),
    icon: 'admin-multisite',
    description: __('Displays other accommodation in the area.', 'tour-operator'),
    category: 'lsx-tour-operator',
    attributes: {
      metadata: {
        name: __('Related accommodation - accommodation', 'tour-operator')
      },
      className: 'lsx-accommodation-related-accommodation-query-wrapper',
      align: 'full',
      layout: {
        type: 'constrained'
      },
      tagName: 'section'
    },
    innerBlocks: [['core/group', {
      align: 'wide',
      layout: {
        type: 'flex',
        flexWrap: 'nowrap'
      }
    }, [['core/separator', {
      style: {
        layout: {
          selfStretch: 'fill',
          flexSize: null
        }
      }
    }], ['core/heading', {
      textAlign: 'center',
      content: __('Related Accommodation', 'tour-operator')
    }], ['core/separator', {
      style: {
        layout: {
          selfStretch: 'fill',
          flexSize: null
        }
      }
    }]]], ['core/group', {
      align: 'wide',
      layout: {
        type: 'constrained'
      }
    }, [['core/query', {
      metadata: {
        name: __('Related Accommodation Query', 'tour-operator')
      },
      query: {
        perPage: 8,
        postType: 'accommodation',
        order: 'asc',
        orderBy: 'date'
      },
      align: 'wide'
    }, [['core/post-template', {
      className: 'lsx-accommodation-related-accommodation-query',
      layout: {
        type: 'grid',
        columnCount: 3
      }
    }, [['core/pattern', {
      slug: 'lsx-tour-operator/accommodation-card'
    }]]]]]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: __('Related Accommodation', 'tour-operator')
        }
      },
      innerBlocks: [['core/group', {}, [['core/heading', {
        content: __('Related Accommodation', 'tour-operator'),
        textAlign: 'center'
      }], ['core/group', {
        style: {
          spacing: {
            blockGap: '2rem'
          }
        },
        layout: {
          type: 'grid',
          columnCount: 3
        }
      }, [['core/group', {
        style: {
          border: {
            width: '1px',
            style: 'solid',
            color: '#e0e0e0'
          },
          spacing: {
            padding: '1rem'
          }
        }
      }, [['core/heading', {
        content: __('Luxury Beach Resort', 'tour-operator'),
        level: 3
      }], ['core/paragraph', {
        content: __('Experience ultimate comfort at our beachfront resort with stunning ocean views and world-class amenities.', 'tour-operator')
      }]]], ['core/group', {
        style: {
          border: {
            width: '1px',
            style: 'solid',
            color: '#e0e0e0'
          },
          spacing: {
            padding: '1rem'
          }
        }
      }, [['core/heading', {
        content: __('Mountain Lodge', 'tour-operator'),
        level: 3
      }], ['core/paragraph', {
        content: __('Cozy mountain retreat perfect for nature lovers seeking tranquility and adventure in the wilderness.', 'tour-operator')
      }]]], ['core/group', {
        style: {
          border: {
            width: '1px',
            style: 'solid',
            color: '#e0e0e0'
          },
          spacing: {
            padding: '1rem'
          }
        }
      }, [['core/heading', {
        content: __('City Center Hotel', 'tour-operator'),
        level: 3
      }], ['core/paragraph', {
        content: __('Modern urban accommodation in the heart of the city with easy access to attractions and dining.', 'tour-operator')
      }]]]]]]]]
    },
    isActive: blockAttributes => {
      return blockAttributes.className === 'lsx-accommodation-related-accommodation-query-wrapper' || blockAttributes.className && blockAttributes.className.includes('lsx-accommodation-related-accommodation-query-wrapper');
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map