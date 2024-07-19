var updateTheme = function() {
    console.log("Theme updated!");
  };

function getTheme() {
    return localStorage.getItem('bsTheme') || 'dark' || document.body.getAttribute('data-bs-theme');
  }