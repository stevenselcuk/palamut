/**
 * WordPress dependencies
 */
const { SVG, Path, G } = wp.components;

/**
 * Block user interface icons
 */
const icons = {};

icons.hero =
<SVG className="dashicon components-palamut-svg" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><Path d="m16 0h-14c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-14c0-1.1-.9-2-2-2zm0 16h-14v-3h14z" transform="translate(3 3)"/></SVG>

icons.grid =
<SVG height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg"><Path d="m11.5 17h4v-2h-4zm4-12h2v-3h-2zm-15-3v13c0 1.1.9 2 2 2h9v-2h-9v-13h13v-2h-13c-1.1 0-2 .9-2 2zm15-2v2h2c0-1.1-.9-2-2-2zm-10 17h2v-16h-2zm-5-7v2h16v-2zm0-5v2h16v-2zm10 12h2v-16h-2zm5-2h2v-2h-2zm0-2h2v-8h-2zm0 4c1.1 0 2-.9 2-2h-2z" transform="matrix(0 1 -1 0 18.5 1)"/></SVG>

export default icons;


