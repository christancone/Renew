document.addEventListener("DOMContentLoaded", function() {
    const shrink_btn = document.querySelector(".shrink-btn");
    const sidebar_links = document.querySelectorAll(".sidebar-links a");
    const active_tab = document.querySelector(".active-tab");
    const shortcuts = document.querySelector(".sidebar-links h4");
    const tooltip_elements = document.querySelectorAll(".tooltip-element");

    fetch('http://localhost/backend/dashboard_process.php')
        .then(response => response.json())
        .then(data => {

            document.querySelector('.outOfStockCount').textContent = data.outOfStock;
            document.querySelector('.lowStockCount').textContent = data.lowStock;
            document.querySelector('.expiredProductsCount').textContent = data.expiredProducts;
        })
        .catch(error => console.error('Error fetching dashboard data:', error));


    let activeIndex = 0;

    shrink_btn.addEventListener("click", () => {
        document.body.classList.toggle("shrink");
        setTimeout(moveActiveTab, 400);

        shrink_btn.classList.add("hovered");

        setTimeout(() => {
            shrink_btn.classList.remove("hovered");
        }, 500);
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
        loadContent(this.getAttribute('data-content'));
    }

    sidebar_links.forEach((link) => link.addEventListener("click", changeLink));

    // Profile-specific functions
    window.toggleDropdown = function() {
        const dropdown = document.getElementById('status-dropdown');
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    window.setStatus = function(status) {
        const statusBtn = document.getElementById('status-btn');
        const statusText = document.getElementById('status-text');
        statusText.textContent = status;
        statusBtn.style.backgroundColor = status === 'ACTIVE' ? '#4CAF50' : '#FF5252';
        toggleDropdown();
    }

    window.toggleEditMode = function() {
        const editSaveBtn = document.getElementById('edit-save-btn');
        const inputs = document.querySelectorAll('input:not([readonly])');

        if (editSaveBtn.textContent.trim() === 'EDIT') {
            editSaveBtn.innerHTML = '<i class="bx bx-save"></i> SAVE';
            editSaveBtn.style.backgroundColor = '#FF9800';
            inputs.forEach(input => input.disabled = false);
        } else {
            editSaveBtn.innerHTML = '<i class="bx bx-edit"></i> EDIT';
            editSaveBtn.style.backgroundColor = '#2196F3';
            inputs.forEach(input => input.disabled = true);
            saveChanges();
        }
    }

    window.saveChanges = function() {
        const formData = new FormData();
        formData.append('firstName', document.getElementById('first-name').value);
        formData.append('lastName', document.getElementById('last-name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('phoneNumber', document.getElementById('phone-number').value);

        fetch('profile_process.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profile updated successfully!');
                } else {
                    alert('Error updating profile. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    }

    function loadContent(page) {
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
                    <div style="font-size: 36px; font-weight: bold; color: #333;" class="outOfStockCount"></div>
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
                    <div style="font-size: 36px; font-weight: bold; color: #333;" class="lowStockCount"></div>
                  </div>
                </div>
                
                <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; width: 300px; margin: 10px;">
                  <h2 style="margin-top: 0; color: #333; font-size: 18px;">Expired Products</h2>
                  <div style="display: flex; align-items: center; margin-top: 20px;">
                    <div style="margin-right: 20px;">
                      <div style="width: 40px; height: 40px; background-color: #6e3cbc; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class='bx bx-x' style="color: white; font-size: 24px;"></i>
                      </div>
                    </div>
                    <div style="font-size: 36px; font-weight: bold; color: #333;" class="expiredProductsCount"></div>
                  </div>
                </div>
            
            `, // Your dashboard content
            'inventory': `<h1>Inventory</h1>...`, // Your inventory content
            'statistics': `<h1>Statistics</h1>...`, // Your statistics content
            'profile': `
                <h1>Profile</h1>
                <div style="max-width: 1000px; margin: 0 auto; background-color: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;">
                    <div style="display: flex; justify-content: space-between; padding: 20px; background-color: #f8f8f8;">
                        <div class="dropdown">
                            <button id="status-btn" onclick="toggleDropdown()" style="padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; font-weight: bold; background-color: #4CAF50; color: white;">
                                <i class='bx bx-check'></i> <span id="status-text">ACTIVE</span> <i class='bx bx-chevron-down'></i>
                            </button>
                            <div id="status-dropdown" class="dropdown-content" style="display: none; position: absolute; background-color: #f9f9f9; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1;">
                                <a href="#" onclick="setStatus('ACTIVE')" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">ACTIVE</a>
                                <a href="#" onclick="setStatus('AWAY')" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">AWAY</a>
                            </div>
                        </div>
                        <button id="edit-save-btn" onclick="toggleEditMode()" style="padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; font-weight: bold; background-color: #2196F3; color: white;">
                            <i class='bx bx-edit'></i> EDIT
                        </button>
                    </div>
                    <div style="display: flex; padding: 20px;">
                        <div style="flex: 2; padding-right: 20px;">
                            <h2>General Information</h2>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <input type="text" placeholder="First Name" id="first-name" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                                <input type="text" placeholder="Last Name" id="last-name" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                                <input type="email" placeholder="Email" id="email" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                                <input type="tel" placeholder="Phone Number" id="phone-number" disabled style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                            </div>
                        </div>
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                            <img src="./img/face-2.jpg" alt="Profile Picture" style="width: 100px; height: 100px; border-radius: 50%; margin-bottom: 20px;">
                            <button id="choose-photo-btn" style="width: 100%; margin-top: 10px; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; background-color: #2196F3; color: white;">
                                <i class='bx bx-camera'></i> CHOOSE PHOTO
                            </button>
                            <div style="width: 100%; margin-top: 20px;">
                             <label style="display: block; margin-bottom: 5px; color: #666;">Username</label>
                             <input type="text" id="username" value="johndoe123" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 15px;">
                            </div>
                        </div>
                    </div>
                </div>
            `
        };

        document.getElementById("main-content").innerHTML = contentMap[page] || '<h1>Page Not Found</h1>';

        if (page === 'dashboard') {
            fetch('http://localhost/backend/dashboard_process.php')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.outOfStockCount').textContent = data.outOfStock;
                    document.querySelector('.lowStockCount').textContent = data.lowStock;
                    document.querySelector('.expiredProductsCount').textContent = data.expiredProducts;
                })
                .catch(error => console.error('Error fetching dashboard data:', error));
        }

        if (page === 'profile') {
            document.getElementById('choose-photo-btn').addEventListener('click', function() {
                alert('Photo upload functionality would be implemented here.');
            });
        }
    }

    loadContent('dashboard'); // Load the dashboard content by default
});