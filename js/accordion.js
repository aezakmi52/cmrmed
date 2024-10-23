// При изменении выбора сортировки, обновляем страницу с новым параметром сортировки
document.getElementById('sort').addEventListener('change', function() {
    document.getElementById('sortForm').submit();
});

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.tab-button-micro');
    const contents = document.querySelectorAll('.tab-content-micro');
    const tabTitle = document.getElementById('activeTabTitle'); // Элемент для заголовка вкладки

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Скрываем все контенты
            contents.forEach(content => content.style.display = 'none');
            
            // Показываем соответствующий контент
            const target = button.getAttribute('data-target');
            const targetContent = document.getElementById(target);
            if (targetContent) {
                targetContent.style.display = 'block';
            }

            // Обновляем заголовок в соответствии с выбранной вкладкой
            const tabTitleText = button.getAttribute('data-title');
            tabTitle.innerText = tabTitleText;
        });
    });
});