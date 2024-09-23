<div class="container">
    <div class="contact-info">
        <p>Email: прописать</p>
        <p>Телефон: прописать</p>
        <p>Адрес: прописать</p>
    </div>
    <div class="feedback">
    <h1>Обратная связь</h1>
    <p>Наш сотрудник ответит вам в ближайшее время</p>
    <form id="feedbackForm" method="post">
        <div>
            <input type="text" name="contact-name" id="contact-name" placeholder="Имя" required>
            <input type="tel" name="phone" id="phone" placeholder="Телефон" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
        </div>
        <button type="submit">Заказать звонок</button>
        <div id="responseMessage"></div>
    </form>
</div>
<script src="js/feedback.js"></script>