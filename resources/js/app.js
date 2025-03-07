import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import PerfectScrollbar from 'perfect-scrollbar'

window.PerfectScrollbar = PerfectScrollbar

document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0

        const getSidebarState = () => {
            if (window.localStorage.getItem('sidebarOpen') !== null) {
                return JSON.parse(window.localStorage.getItem('sidebarOpen'))
            }
            return window.innerWidth > 1024
        }

        const setSidebarState = (value) => {
            window.localStorage.setItem('sidebarOpen', JSON.stringify(value))
        }

        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }
            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        }
        const setTheme = (value) => {
            window.localStorage.setItem('dark', value)
        }

        const init = function () {
            window.addEventListener('scroll', () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true
                    this.scrollingUp = false
                } else {
                    // upscroll
                    this.scrollingDown = false
                    this.scrollingUp = true
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false
                        this.scrollingUp = false
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st // For Mobile or negative scrolling
            })
        }

        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode
                setTheme(this.isDarkMode)
            },
            isSidebarOpen: getSidebarState(),
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return
                }
                this.isSidebarHovered = value
            },
            handleWindowResize() {
                if (window.innerWidth <= 768) {
                    this.isSidebarOpen = false
                    setSidebarState(false)
                } else if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                    setSidebarState(false)
                } else {
                    this.isSidebarOpen = true
                    setSidebarState(true)
                }
            },
            toggleSidebar() {
                this.isSidebarOpen = !this.isSidebarOpen
                setSidebarState(this.isSidebarOpen)
            },
            scrollingDown: false,
            scrollingUp: false,
        }
    })
})

Alpine.plugin(collapse)

Alpine.start()