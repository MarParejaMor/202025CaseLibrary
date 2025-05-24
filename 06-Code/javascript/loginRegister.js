// Manejar pantalla de bienvenida
document.getElementById('toLogin').addEventListener('click', () => {
  document.getElementById('welcomeScreen').style.display = 'none';
  document.getElementById('mainContainer').style.display = 'flex';
  bootstrap.Tab.getOrCreateInstance(document.querySelector('#login-tab')).show();
});
document.getElementById('toRegister').addEventListener('click', () => {
  document.getElementById('welcomeScreen').style.display = 'none';
  document.getElementById('mainContainer').style.display = 'flex';
  bootstrap.Tab.getOrCreateInstance(document.querySelector('#register-tab')).show();
});

// LOGIN
document.getElementById("loginForm").addEventListener("submit", async function(e) {
  e.preventDefault();
  const userInput = document.getElementById("userInput").value.trim();
  const password  = document.getElementById("loginPassword").value;

  if (!userInput || !password) {
    return alert("Por favor, completa todos los campos.");
  }

  const formData = new FormData();
  formData.append("userInput", userInput);
  formData.append("password",  password);

  try {
    const res = await fetch("../php/login.php", { method: "POST", body: formData });
    const result = await res.json();
    if (result.success) {
      alert(result.message);
      window.location.href = "dashboard.php";
    } else {
      alert(result.message);
    }
  } catch {
    alert("Error de conexión con el servidor.");
  }
});

// REGISTRO
document.getElementById("registerForm").addEventListener("submit", async function(e) {
  e.preventDefault();
  const username = document.getElementById("regUsername").value.trim();
  const email    = document.getElementById("regEmail").value.trim();
  const phone    = document.getElementById("regPhone").value.trim();
  const password = document.getElementById("regPassword").value;
  const confirm  = document.getElementById("regPasswordConfirm").value;

  // Validar obligatorio
  if (!username || !email || !phone || !password || !confirm) {
    return alert("Completa todos los campos obligatorios.");
  }
  // Usuario: solo letras y un espacio
  if (!/^[A-Za-z]+ [A-Za-z]+$/.test(username)) {
    return alert("Nombre inválido. Ejemplo: Juan Pérez (solo letras y un espacio).");
  }
  // Email
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return alert("Correo electrónico inválido.");
  }
  // Teléfono Ecuador: empieza 09 y 10 dígitos
  if (!/^09\d{8}$/.test(phone)) {
    return alert("Teléfono inválido. Debe iniciar en 09 y tener 10 dígitos.");
  }
  // Contraseñas coinciden
  if (password !== confirm) {
    return alert("Las contraseñas no coinciden.");
  }
  // Contraseña: 8 car, 1 mayús, 3 dígitos, 1 especial
  if (!/^(?=.*[A-Z])(?=(?:.*\d){3,})(?=.*[\W_]).{8,}$/.test(password)) {
    return alert("La contraseña no cumple los requisitos.");
  }

  const formData = new FormData();
  formData.append("username", username);
  formData.append("email",    email);
  formData.append("phone_number", phone);
  formData.append("password", password);

  try {
    const res = await fetch("../php/register.php", { method: "POST", body: formData });
    const result = await res.json();
    if (result.success) {
      alert(result.message);
      this.reset();
      // Cambiar a pestaña de login
      bootstrap.Tab.getOrCreateInstance(document.querySelector('#login-tab')).show();
    } else {
      alert(result.message);
    }
  } catch {
    alert("Error de conexión con el servidor.");
  }
});
