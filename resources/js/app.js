import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // Анимация появления ошибок с задержкой
    const errorMessages = document.querySelectorAll('[class*="text-red"]');
    errorMessages.forEach((el, index) => {
        el.style.opacity = 0;
        el.style.transition = `opacity 0.3s ease ${index * 0.08}s`;
        requestAnimationFrame(() => {
            el.style.opacity = 1;
        });
    });

    // Визуальная подсветка радио-ролей (дополнительно к CSS :checked, на случай старых браузеров)
    const radioInputs = document.querySelectorAll('.role-radio');
    radioInputs.forEach(radio => {
        radio.addEventListener('change', (e) => {
            // снимаем все выделения
            document.querySelectorAll('.role-label').forEach(label => {
                label.classList.remove('border-mint', 'bg-mint/10');
            });
            // добавляем выделение текущему
            if (e.target.checked) {
                const label = e.target.closest('.role-label');
                if (label) {
                    label.classList.add('border-mint', 'bg-mint/10');
                }
            }
        });
    });

    // Инициализация при загрузке (если уже checked)
    document.querySelectorAll('.role-radio:checked').forEach(radio => {
        const label = radio.closest('.role-label');
        if (label) {
            label.classList.add('border-mint', 'bg-mint/10');
        }
    });
});