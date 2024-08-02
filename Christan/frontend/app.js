const shrink_btn = document.querySelector(".shrink-btn");
const search = document.querySelector(".search");
const sidebar_links = document.querySelectorAll(".sidebar-links a");
const active_tab = document.querySelector(".active-tab");
const shortcuts = document.querySelector(".sidebar-links h4");
const tooltip_elements = document.querySelectorAll(".tooltip-element");

let activeIndex;

shrink_btn.addEventListener("click", () => {
  document.body.classList.toggle("shrink");
  setTimeout(moveActiveTab, 400);

  shrink_btn.classList.add("hovered");

  setTimeout(() => {
    shrink_btn.classList.remove("hovered");
  }, 500);
});

search.addEventListener("click", () => {
  document.body.classList.remove("shrink");
  search.lastElementChild.focus();
});

function moveActiveTab() {
  let topPosition = activeIndex * 58 + 2.5;

  if (activeIndex > 3) {
    topPosition += shortcuts.clientHeight;
  }

  active_tab.style.top = `${topPosition}px`;
}

function changeLink() {
  sidebar_links.forEach((sideLink) => sideLink.classList.remove("active"));
  this.classList.add("active");

  activeIndex = this.dataset.active;

  moveActiveTab();
}

sidebar_links.forEach((link) => link.addEventListener("click", changeLink));

function showTooltip() {
  let tooltip = this.parentNode.lastElementChild;
  let spans = tooltip.children;
  let tooltipIndex = this.dataset.tooltip;

  Array.from(spans).forEach((sp) => sp.classList.remove("show"));
  spans[tooltipIndex].classList.add("show");

  tooltip.style.top = `${(100 / (spans.length * 2)) * (tooltipIndex * 2 + 1)}%`;
}

tooltip_elements.forEach((elem) => {
  elem.addEventListener("mouseover", showTooltip);
});

document.addEventListener("DOMContentLoaded", function() {
  const links = document.querySelectorAll('.sidebar-links a');
  const mainContent = document.getElementById('main-content');

  const contentMap = {
    'dashboard': `
      <h1>My Dashboard</h1>
      <div style="display: flex; justify-content: flex-start; align-items: center; margin: 0; background-color: #f0f0f0;"></div>
      <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; width: 300px; margin: 10px;">
        <h2 style="margin-top: 0; color: #333; font-size: 18px;">Products Out of Stock</h2>
        <div style="display: flex; align-items: center; margin-top: 20px;">
          <div style="margin-right: 20px;">
            <div style="width: 40px; height: 40px; background-color: #ff4d4d; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
              <i class='bx bx-block' style="color: white; font-size: 24px;"></i>
            </div>
          </div>
          <div style="font-size: 36px; font-weight: bold; color: #333;">0</div>
        </div>
      </div>
      
      <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; width: 300px; margin: 10px;">
        <h2 style="margin-top: 0; color: #333; font-size: 18px;">Low on Stock</h2>
        <div style="display: flex; align-items: center; margin-top: 20px;">
          <div style="margin-right: 20px;">
            <div style="width: 40px; height: 40px; background-color: #ffcc00; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
              <i class='bx bx-low-vision' style="color: white; font-size: 24px;"></i>
            </div>
          </div>
          <div style="font-size: 36px; font-weight: bold; color: #333;">5</div>
        </div>
      </div>
      
      <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; width: 300px; margin: 10px;">
        <h2 style="margin-top: 0; color: #333; font-size: 18px;">Expired Products</h2>
        <div style="display: flex; align-items: center; margin-top: 20px;">
          <div style="margin-right: 20px;">
            <div style="width: 40px; height: 40px; background-color: #ff4d4d; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
              <i class='bx bx-error' style="color: white; font-size: 24px;"></i>
            </div>
          </div>
          <div style="font-size: 36px; font-weight: bold; color: #333;">2</div>
        </div>
      </div>
    `,
    'inventory': `
      <h1>Inventory</h1>
      <p>Inventory content goes here.</p>
    `,
    'statistics': `
      <h1>Statistics</h1>
      <p>Statistics content goes here.</p>
    `,
    'profile': `
      <h1>Profile</h1>
      <div style="max-width: 1000px; margin: 0 auto; background-color: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="display: flex; justify-content: space-between; padding: 20px; background-color: #f8f8f8;">
            <div class="dropdown">
                <button class="active-btn" style="padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; font-weight: bold; background-color: #4CAF50; color: white;">
                    <i class='bx bx-check'></i> <span id="status-text">ACTIVE</span> <i class='bx bx-chevron-down'></i>
                </button>
                <div class="dropdown-content" style="display: none; position: absolute; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1;">
                    <a href="#" onclick="setStatus('ACTIVE')" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">ACTIVE</a>
                    <a href="#" onclick="setStatus('AWAY')" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">AWAY</a>
                </div>
            </div>
            <button class="edit-btn" onclick="toggleEditMode()" style="padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; font-weight: bold; background-color: #2196F3; color: white;">
                <i class='bx bx-edit'></i> EDIT
            </button>
        </div>
        <div style="display: flex; padding: 20px;">
            <div style="flex: 2; padding-right: 20px;">
                <h2>General Information</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <input type="text" placeholder="First Name" id="first-name" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="text" placeholder="Last Name" id="last-name" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="text" placeholder="Birthday" id="birthday" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                        <i class='bx bx-calendar' style="position: absolute; right: 10px;"></i>
                    </div>
                    <div style="position: relative; display: flex; align-items: center;">
                        <input type="text" placeholder="Gender" id="gender" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                        <i class='bx bx-chevron-down' style="position: absolute; right: 10px;"></i>
                    </div>
                    <input type="email" placeholder="Email" id="email" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="tel" placeholder="Phone Number" id="phone-number" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                </div>
            </div>
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                <img src="imgace-2.jpg" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 20px;">
                <button style="width: 100%; margin-top: 10px; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; font-weight: bold; background-color: #2196F3; color: white;">
                    <i class='bx bx-camera'></i> CHOOSE PHOTO
                </button>
                <div style="width: 100%; margin-top: 20px;">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Name</label>
                    <input type="text" id="name" value="John Doe" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Username</label>
                    <input type="text" id="username" value="johndoe123" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 15px;">
                </div>kddmdwlmlwm
                <button style="width: 100%; margin-top: 10px; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; font-weight: bold; background-color: #2196F3; color: white;">
                    CHANGE PASSWORD
                </button>
            </div>
        </div>
      </div>
    `

    
  };

  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const contentKey = this.getAttribute('data-content');
      if (contentMap[contentKey]) {
        mainContent.innerHTML = contentMap[contentKey];
      }
    });
  });

  window.toggleEditMode = function() {
    const editBtn = document.querySelector('.edit-btn');
    const inputs = document.querySelectorAll('input:not([readonly])');
    if (editBtn.innerHTML.includes('EDIT')) {
        // Change to Save mode
        inputs.forEach(input => input.disabled = false);
        editBtn.innerHTML = "<i class='bx bx-save'></i> SAVE";
        editBtn.style.backgroundColor = "#4CAF50";
    } else {
        // Change to Edit mode
        inputs.forEach(input => input.disabled = true);
        editBtn.innerHTML = "<i class='bx bx-edit'></i> EDIT";
        editBtn.style.backgroundColor = "#2196F3";
    }
}

window.setStatus = function(status) {
    document.getElementById('status-text').innerText = status;
    const activeBtn = document.querySelector('.active-btn');
    if (status === 'ACTIVE') {
        activeBtn.style.backgroundColor = '#4CAF50';
    } else {
        activeBtn.style.backgroundColor = '#FFA500';
    }
    // Hide dropdown after selection
    document.querySelector('.dropdown-content').style.display = 'none';
}

// Add event listener for status dropdown
document.addEventListener('click', function(event) {
    const dropdownContent = document.querySelector('.dropdown-content');
    const activeBtn = event.target.closest('.active-btn');
    
    if (activeBtn) {
        dropdownContent.style.display = dropdownContent.style.display === 'none' ? 'block' : 'none';
    } else if (!event.target.closest('.dropdown-content')) {
        if (dropdownContent) {
            dropdownContent.style.display = 'none';
        }
    }
});
});


