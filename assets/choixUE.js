document.addEventListener('DOMContentLoaded', function() {
    const notiCountSelect = document.getElementById('notiCount');
    const notifications = document.querySelectorAll('.noti-navigation .boxnoti');

    // Handle course display limit
    const courseCountSelect = document.createElement('select');
    courseCountSelect.id = 'courseCount';
    courseCountSelect.innerHTML = `
        <option value="2">2</option>
        <option value="4">4</option>
        <option value="all">Tous</option>
    `;

    // Find the correct section with 'Mes cours'
    const sections = document.querySelectorAll('.section');
    let courseSection = null;

    sections.forEach(section => {
        const h1 = section.querySelector('h1');
        if (h1 && h1.textContent.trim() === 'Mes cours') {
            courseSection = section;
        }
    });

    if (courseSection) {
        const oldSelect = courseSection.querySelector('select');
        if (oldSelect) {
            oldSelect.replaceWith(courseCountSelect);
        }
    }

    const courses = document.querySelectorAll('.course-navigation .boxUE');

    function updateDisplay(selectElement, items) {
        const value = selectElement.value;
        items.forEach((item, index) => {
            if (value === 'all' || index < parseInt(value)) {
                item.style.display = 'grid';
            } else {
                item.style.display = 'none';
            }
        });
    }

    if (notiCountSelect) {
        notiCountSelect.addEventListener('change', function() {
            updateDisplay(this, notifications);
        });
        updateDisplay(notiCountSelect, notifications);
    }

    if (courseCountSelect) {
        courseCountSelect.addEventListener('change', function() {
            updateDisplay(this, courses);
        });
        updateDisplay(courseCountSelect, courses);
    }
});
