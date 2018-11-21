/******************
 * File functions *
 ******************/

/**
 * Get extension from filename
 *
 * @param {string} fileName
 * @return {string|*}
 * @private
 */
function _getExt(fileName) {
    return fileName.substr(fileName.lastIndexOf('.') + 1);
}

/**
 * Check if string has extension
 *
 * @param {string} value
 * @param {array} extensions
 * @param {boolean} hardDetection
 * @return {boolean}
 * @private
 */
function _hasExt(value, extensions, hardDetection = true) {
    let result = false;

    if (hardDetection) {
        value = value.indexOf('?') > -1
            ? value.substr(0, value.indexOf('?'))
            : value;
    }

    extensions.forEach((extension) => {
        if (value.endsWith(extension)) {
            result = true;
            return false;
        }
    });

    return result;
}

/**
 * Exports file functions
 * @public
 */
module.exports.file = {
    getExt: _getExt,
    hasExt: _hasExt
};

/*********************
 * Element functions *
 *********************/

/**
 * Check if HTML element is visible
 *
 * @param {HTMLElement} element
 * @return {boolean}
 * @private
 */
function _isVisible(element) {
    let style = window.getComputedStyle(element);

    return style.clientWidth !== 0 &&
        style.clientHeight !== 0 &&
        style.opacity !== 0 &&
        style.display !== 'none' &&
        style.visibility !== 'hidden';
}

/**
 * Check if element has a class
 *
 * @param {HTMLElement} element
 * @param {string} className
 * @return {boolean}
 * @private
 */
function _hasClass(element, className) {
    return (' '+element.className+' ').indexOf(' '+className+' ') > -1;
}

/**
 * Exports HTML functions
 * @public
 */
module.exports.element = {
    hasClass: _hasClass,
    isVisible: _isVisible
};
