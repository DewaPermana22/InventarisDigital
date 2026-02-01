
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

document.addEventListener('livewire:navigating', () => {
    NProgress.start()
})

document.addEventListener('livewire:navigated', () => {
    NProgress.done()
})

document.addEventListener('livewire:request', () => {
    NProgress.start()
})

document.addEventListener('livewire:response', () => {
    NProgress.done()
})
