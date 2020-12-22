
export const toggleMenuIcon = (element) =>
{
    if (classContains(element, 'fa-bars'))
    {
        removeClass(element, 'fa-bars');
        addClass(element, 'fa-times');
    }
    else
    {
        removeClass(element, 'fa-times');
        addClass(element, 'fa-bars');
    }
};

export const toggleMenuIconOnWindowSize = (width, element) =>
{
    if (width <= 768)
    {
        addClass(element, 'fa-bars');
        removeClass(element, 'fa-times');
    }
    else
    {
        removeClass(element, 'fa-bars');
        addClass(element, 'fa-times');
    }
};



/**
 *
 * Element Class names modification
 */

export const addClass = (element, classNames) => element ?  element.classList.add(classNames) : '';
export const removeClass = (element, classNames) => element ? element.classList.remove(classNames) : '';
export const classContains = (element, classNames) => element ? element.classList.contains(classNames) : '';
export const toggleClass = (element, classNames) => element ? element.classList.toggle(classNames) : '';
/**
 * Select Element
 */

export const select = (selector) => document.querySelector(selector);

