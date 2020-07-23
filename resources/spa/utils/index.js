import { BASE_URL, SEPARATOR } from '../config/constants';

/**
 * Try to fix the url if it is not in gentle form
 * @param {string} url
 * @returns {string}
 */
export function fixUrl(url) {
    // url relative to the base url
    if (url.startsWith('/')) return BASE_URL + url;
    // it is eighter http or https and it is full path
    if (url.startsWith('http')) return url;
    // asuming it is relative to current location
    return window.location + SEPARATOR + url;
}

/**
 * 
 * @param {string} s1 
 * @param {string} s2 
 * @returns {boolean}
 */
export function matchString(s1, s2) {
    return s1.length === s2.length && s1.startsWith(s2);
}