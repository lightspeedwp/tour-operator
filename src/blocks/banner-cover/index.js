import { registerBlockVariation } from '@wordpress/blocks';
import { store } from '@wordpress/block-editor';
import { select } from '@wordpress/data';
import metadata from './block.json';

registerBlockVariation('core/cover', {
    name: metadata.name,
    title: metadata.title,
    description: metadata.description,
    icon: metadata.icon,
    category: metadata.category,
    attributes: metadata.attributes,
    isActive: ['metadata', 'className'],
    supports: metadata.supports
});