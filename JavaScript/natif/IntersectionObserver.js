window.addEventListener("DOMContentLoaded", (event) => {

    let observer = new IntersectionObserver((entries => {
        entries.forEach((entrie) => {
            if (entrie.intersectionRatio > 0.7) {
                entrie.target.classList.remove('not-visible')
                entrie.target.classList.add('zoomIn')
            }
        })
    }), {
        threshold: [0.7] // 70% of vision
    })

    let items = document.querySelectorAll('.animation')
    items.forEach((item) => {
        item.classList.add('not-visible')
        observer.observe(item)
    })

})
