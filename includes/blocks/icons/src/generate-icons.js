const fs = require('fs');
const path = require('path');

const ICONS_DIR = path.join(__dirname, 'source-icons');
const OUTPUT_FILE_REACT = path.join(__dirname, 'icons.react.js');

function getIconsFromDir(dir) {
  const icons = {};
  const files = fs.readdirSync(dir);
  files.forEach(file => {
    const filePath = path.join(dir, file);
    const stat = fs.statSync(filePath);
    if (stat.isDirectory()) {
      icons[file] = getIconsFromDir(filePath);
    } else if (file.endsWith('.svg')) {
      const iconName = path.basename(file, '.svg');
      const svgContent = fs.readFileSync(filePath, 'utf8').replace(/\r?\n|\r/g, '');
      icons[iconName] = svgContent;
    }
  });
  return icons;
}

const icons = getIconsFromDir(ICONS_DIR);

function toCamelCase(str) {
  return str.replace(/[-_](\w)/g, (_, c) => c ? c.toUpperCase() : '').replace(/^(\d)/, '_$1');
}

function svgToJSX(svg) {
  // Replace <svg ...> with <svg {...props} ...>
  return svg.replace(/<svg(\s|>)/i, '<svg {...props}$1')
    // Convert attributes to camelCase for JSX
    .replace(/([a-zA-Z-]+)=/g, (m, p1) => {
      let attr = p1.replace(/-([a-z])/g, (g) => g[1].toUpperCase());
      if (attr === 'class') attr = 'className';
      return attr + '=';
    });
}

function iconsToReactComponents(iconsObj, indent = '  ') {
  let out = '{\n';
  for (const [type, icons] of Object.entries(iconsObj)) {
    out += `${indent}${type}: {\n`;
    for (const [name, svg] of Object.entries(icons)) {
      const camelName = toCamelCase(name);
      const jsx = svgToJSX(svg);
      out += `${indent}  ${camelName}: (props) => (\n${indent}    ${jsx}\n${indent}  ),\n`;
    }
    out += `${indent}},\n`;
  }
  out += '};';
  return out;
}

const reactOutput = `// AUTO-GENERATED FILE. DO NOT EDIT.\n// \nimport React from 'react';\n\nconst icons = ${iconsToReactComponents(icons)}\n\nexport default icons;\n`;

fs.writeFileSync(OUTPUT_FILE_REACT, reactOutput);

console.log('icons.react.js generated successfully!');
