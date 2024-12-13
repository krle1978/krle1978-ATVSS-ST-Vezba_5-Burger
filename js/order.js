fetch('DataBase/process.php', {
    method: 'POST',
    body: formData
})
.then(response => response.text())
.then(data => {
    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = data;
    resultDiv.style.display = 'block';
})
.catch(error => {
    console.error('Greška:', error);
    alert('Došlo je do greške pri obradi narudžbine.');
});
