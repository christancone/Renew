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

  if (activeIndex > 4) {
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
    

    
  };
  
  function loadProfileContent() {
    fetch('profile.php')
      .then(response => response.text())
      .then(data => mainContent.innerHTML = data)
      .catch(error => console.error('Error loading profile content:', error));
  }
function loadEditStockContent(event, id) {
    event.preventDefault(); // Prevent default link behavior

    // Ensure `mainContent` is correctly defined
    const mainContent = document.getElementById('mainContent'); 

    fetch('edit_stock.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            mainContent.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading stock content:', error);
        });
}


  function loadDashboardContent() {
    fetch('dashboard.php')
      .then(response => response.text())
      .then(data => mainContent.innerHTML = data)
      .catch(error => console.error('Error loading profile content:', error));
  }
  function loadInventorCountContent() {
    fetch('inventory_count.php')
      .then(response => response.text())
      .then(data => mainContent.innerHTML = data)
      .catch(error => console.error('Error loading count content:', error));
  }
  window.onload = function() {
            loadDashboardContent();
        };
  
  function loadInventoryContent() {
    fetch('inventory.php')
      .then(response => response.text())
      .then(data => mainContent.innerHTML = data)
      .catch(error => console.error('Error loading profile content:', error));
  }
    function loadAddInventoryContent() {
    fetch('add_inventory.php')
      .then(response => response.text())
      .then(data => mainContent.innerHTML = data)
      .catch(error => console.error('Error loading add_inventory content:', error));
  }
  function loadStatisticsContent() {
    fetch('statistics.php')
      .then(response => response.text())
      .then(data => mainContent.innerHTML = data)
      .catch(error => console.error('Error loading profile content:', error));
  }
  
  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const contentKey = this.getAttribute('data-content');
      if(contentKey ===  'profile'){
          loadProfileContent();
      }else if(contentKey ===  'dashboard'){
          loadDashboardContent();
      }else if(contentKey ===  'inventory'){
          loadInventoryContent();
      }else if(contentKey ===  'add_inventory'){
           loadAddInventoryContent();
      }else if(contentKey ===  'statistics'){
          loadStatisticsContent();
      }else if (contentMap[contentKey]) {
        mainContent.innerHTML = contentMap[contentKey];
      }else if(contentKey ===  'InventoryCount'){
         loadInventorCountContent();
      }
    });
  });

  window.toggleEditMode = function() {
    const editBtn = document.querySelector('.edit-btn');
    const inputs = document.querySelectorAll('input:not([readonly]):not(#curPwd):not(#newPwd)');
    const select = document.querySelector('#role');
    if (editBtn.innerHTML.includes('EDIT')) {
        // Change to Save mode
        select.removeAttribute('disabled');
        inputs.forEach(input => input.disabled = false );
        editBtn.innerHTML = "<i class='bx bx-save'></i> SAVE";
        editBtn.style.backgroundColor = "#4CAF50";
    } else {
        // Change to Edit mode
        select.setAttribute('disabled', 'disabled');
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


function togglePasswordSection() {
            const hiddenPasswordDiv = document.getElementById('hidden-password');
            if (hiddenPasswordDiv.style.display === 'none' || hiddenPasswordDiv.style.display === '') {
                hiddenPasswordDiv.style.display = 'block';
            } else {
                hiddenPasswordDiv.style.display = 'none';
            }
        }

