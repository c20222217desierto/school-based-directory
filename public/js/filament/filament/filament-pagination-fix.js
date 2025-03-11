document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("livewire:load", function () {
        Livewire.hook("message.processed", (message, component) => {
            setTimeout(() => {
                document.querySelectorAll('[aria-current="page"]').forEach(el => {
                    el.classList.add('bg-amber-500', 'text-white', 'rounded-md', 'px-3', 'py-1');
                });
            }, 100);
        });
    });
});
