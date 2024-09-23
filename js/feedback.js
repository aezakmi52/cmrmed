document.getElementById('feedbackForm').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const name = document.getElementById('contact-name').value.trim();
    const phone = document.getElementById('phone').value.trim();

    const formData = new FormData();
    formData.append('contact-name', name);
    formData.append('phone', phone);
    

    fetch('feedback.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const responseMessage = document.getElementById('responseMessage');
        if (data.status === 'success') {
            responseMessage.textContent = data.message;
            responseMessage.style.color = 'green';
        } else {
            responseMessage.textContent = data.message;
            responseMessage.style.color = 'red';
        }

        document.getElementById('feedbackForm').reset();
        
    })
    .catch(error => {
        console.error('Ошибка:', error);
    });
});
