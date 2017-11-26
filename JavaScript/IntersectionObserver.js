/*
 *	Allow to set a transition when client see a target automatically
 *	Need a polifyle => https://github.com/w3c/IntersectionObserver/blob/master/polyfill/intersection-observer.js
*/
let observer = new IntersectionObserver(function (observables) {
    observables.forEach(function (observable) {
        // L'élément devient visible
        if (observable.intersectionRatio > 0.7) {
            observable.target.classList.remove('invisible')
            observable.target.classList.add('animated')
            observable.target.classList.add('zoomIn')
            observer.unobserve(observable.target)
        }
    })
}, {
    threshold: [0.7]
});

// observe elements
let items = $('.animation')
items.each(function (id) {
    observer.observe(items[id])
})