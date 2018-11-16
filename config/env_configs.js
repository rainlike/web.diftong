// eslint-disable-next-line no-unused-vars
const dotenv = require('../node_modules/dotenv').config();

/**
 * Get configs for env
 *
 * @param env String
 * @returns Object
 * @private
 */
function _get (env = process.env.APP_ENV) {
    const common = {
        prefix: process.env.APP_PREFIX
    };

    const configs = {
        dev: {source_maps: 'source-map'},
        prod: {source_maps: 'nosources-source-map'}
    };

    return Object.assign(common, configs[env]);
}

/**
 * Exports
 * @public
 */
module.exports.get = _get;
