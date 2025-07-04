document.addEventListener("DOMContentLoaded", () => {
  const formPanel = document.getElementById("formPanel");

  const loadTemplate = (type) => {
    formPanel.innerHTML = type === "signup" ? buildSignUp() : buildLogin();
    bindLinks();
  };

  const buildLogin = () => `
    <form class="fade-slide">
      <h2>Login</h2>
      <div class="field-row">
        <input type="email" required />
        <label>Webmail ID</label>
      </div>
      <div class="field-row">
        <input type="password" required />
        <label>Password</label>
      </div>
      <div class="field-row">
        <input type="text" required />
        <label>Your Name</label>
      </div>
      <div class="field-row">
        <select required>
          <option value="" disabled selected>Select Role</option>
          <option>SubCordinator</option>
          <option>Coordinator</option>
        </select>
        <label>Position</label>
      </div>
      <button type="submit" class="neon-button">Login</button>
      <div class="switch-prompt">
        <p>New user? <a href="#" id="toRegister">Register here</a></p>
      </div>
    </form>
  `;

  const buildSignUp = () => `
    <form class="fade-slide">
      <h2>Register</h2>
      <div class="field-row">
        <input type="text" required />
        <label>Roll Number</label>
      </div>
      <div class="field-row">
        <select required>
          <option value="" disabled selected>Select Degree</option>
          <option>ECE</option>
          <option>EEE</option>
          <option>Dual Degree</option>
        </select>
        <label>Program</label>
      </div>
      <div class="field-row">
        <input type="tel" required />
        <label>Phone Number</label>
      </div>
      <div class="field-row">
        <input type="email" required />
        <label>Webmail ID</label>
      </div>
      <div class="field-row">
        <input type="password" required />
        <label>Password</label>
      </div>
      <div class="field-row">
        <input type="text" required />
        <label>Your Name</label>
      </div>
      <div class="field-row">
        <select required>
          <option value="" disabled selected>Select Role</option>
          <option>SubCordinator</option>
          <option>Cordinator</option>
        </select>
        <label>Position</label>
      </div>
      <button type="submit" class="neon-button">Register</button>
      <div class="switch-prompt">
        <p>Already registered? <a href="#" id="toLogin">Login here</a></p>
      </div>
    </form>
  `;

  const bindLinks = () => {
    const toRegister = document.getElementById("toRegister");
    const toLogin = document.getElementById("toLogin");

    if (toRegister) {
      toRegister.addEventListener("click", (e) => {
        e.preventDefault();
        loadTemplate("signup");
      });
    }

    if (toLogin) {
      toLogin.addEventListener("click", (e) => {
        e.preventDefault();
        loadTemplate("login");
      });
    }
  };

  loadTemplate("login");
});