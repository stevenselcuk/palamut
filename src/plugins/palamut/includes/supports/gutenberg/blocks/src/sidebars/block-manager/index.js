/**
 * Internal dependencies
 */
import './styles/editor.scss';
import icons from './../../utils/icons';
import ModalSettings from './components/modal';

/**
 * WordPress dependencies
 */
const { registerPlugin } = wp.plugins;

/**
 * Register Plugin
 */
registerPlugin( 'palamut-block-manager', {
	icon: false,
	render: ModalSettings,
} );