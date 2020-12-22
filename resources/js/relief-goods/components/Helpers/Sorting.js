/* * * * * * * * * * * * * * * *
 |
 | Sorting
 |______________________________*/


/**
 * Ascending order
 * @param {*} arr
 */
export const toAscSort = (arr) => arr.sort((a, b) => a.id - b.id);

/**
 * Descending order
 * @param {*} arr
 */
export const toDescSort = (arr) => arr.sort((a, b) => b.id - a.id);

/**
 * Check of array is sorted in ascending order
 * @param {*} arr
 * @returns @boolean
 */
export const isSortedAsc = (arr) => arr.reduce((accu, current) => Boolean( accu && current >= accu && current ));

/**
 * Check if array is sorted in descending order
 * @param {*} arr
 * @returns @boolean
 */
export const isSortedDesc = (arr) => arr.reduce((accu, current) => Boolean( accu && current <= accu && current ));

/**
 * Check if array is sorted either ascending or descending order
 * @param {*} arr
 * @returns @boolean
 */
export const isSorted = (arr) => isSortedAsc(arr) || isSortedDesc(arr);
