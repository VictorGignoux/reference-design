textareas = document.querySelectorAll('textarea');
console.log(textareas);
textareas.forEach(textarea => {
      textarea.addEventListener('input', () => {
            textarea.style.height = 'auto'; // Réinitialise la hauteur
            textarea.style.height = `${textarea.scrollHeight}px`; // Ajuste à la nouvelle hauteur
      });
});