/******/ (() => { // webpackBootstrap
/*!********************************************************!*\
  !*** ./src/blocks/accommodation-related-tour/index.js ***!
  \********************************************************/
wp.domReady(() => {
  wp.blocks.registerBlockVariation('core/group', {
    name: 'lsx-tour-operator/accommodation-related-tour',
    title: 'Related Accommodation - Tour',
    icon: 'palmtree',
    description: 'Displays Accommodation related to this Tour via the destinations.',
    category: 'lsx-tour-operator',
    attributes: {
      metadata: {
        name: 'Related Accommodation - Tour'
      },
      className: 'lsx-accommodation-related-tour-query-wrapper',
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
      content: 'Related Accommodation'
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
        name: 'Related Accommodation Query'
      },
      query: {
        perPage: 8,
        postType: 'accommodation',
        order: 'asc',
        orderBy: 'date'
      },
      align: 'wide'
    }, [['core/post-template', {
      className: 'lsx-accommodation-related-tour-query',
      layout: {
        type: 'grid',
        columnCount: 3
      }
    }, [['core/pattern', {
      slug: 'lsx-tour-operator/destination-card'
    }]]]]]]]],
    supports: {
      renaming: false
    },
    example: {
      attributes: {
        metadata: {
          name: 'Related Tours'
        }
      },
      innerBlocks: [['core/group', {}, [['core/heading', {
        content: 'Related Tours',
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
        content: 'African Safari Adventure',
        level: 3
      }], ['core/paragraph', {
        content: "Embark on an unforgettable 7-day safari experience through Kenya's most spectacular wildlife reserves."
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
        content: 'European Cultural Journey',
        level: 3
      }], ['core/paragraph', {
        content: 'Discover the rich history and culture of Europe with visits to iconic cities and historic landmarks.'
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
        content: 'Tropical Island Escape',
        level: 3
      }], ['core/paragraph', {
        content: 'Relax and unwind on pristine beaches with crystal clear waters and vibrant coral reefs.'
      }]]]]]]]]
    }
  });
});
/******/ })()
;
//# sourceMappingURL=index.js.map