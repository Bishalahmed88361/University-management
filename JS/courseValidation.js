let isIdUnique = false;
let isCodeUnique = false;

function checkUniqueness(field, value, errorElementId) {
    const errorSpan = document.getElementById(errorElementId);
    
    if (!value.trim()) {
        errorSpan.innerText = "";
        if (field === 'course_id') isIdUnique = false;
        if (field === 'course_code') isCodeUnique = false;
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `../Controller/courseController.php?action=check_unique&field=${field}&value=` + encodeURIComponent(value), true);
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const res = JSON.parse(xhr.responseText);
                if (!res.isUnique) {
                    errorSpan.innerText = field === 'course_id' ? "Course ID already exists!" : "Course Code already exists!";
                    errorSpan.style.color = "#a00000";
                    if (field === 'course_id') isIdUnique = false;
                    if (field === 'course_code') isCodeUnique = false;
                } else {
                    errorSpan.innerText = "Available";
                    errorSpan.style.color = "#155724";
                    if (field === 'course_id') isIdUnique = true;
                    if (field === 'course_code') isCodeUnique = true;
                }
            } catch (e) {
                console.error("Error parsing JSON response:", xhr.responseText);
            }
        }
    };
    xhr.send();
}

function validateCourseForm() {
    let courseID = document.querySelector("[name='course_id']").value.trim();
    let courseName = document.querySelector("[name='course_name']").value.trim();
    let courseCode = document.querySelector("[name='course_code']").value.trim();
    let credit = document.querySelector("[name='credit']").value;
    let day = document.querySelector("[name='day']").value;
    let startTime = document.querySelector("[name='start_time']").value.trim();
    let endTime = document.querySelector("[name='end_time']").value.trim();

    if (courseID === "" || courseName === "" || courseCode === "" || credit === "" || day === "" || startTime === "" || endTime === "") {
        alert("Please fill in all fields.");
        return false;
    }

    if (!isIdUnique || !isCodeUnique) {
        alert("Course ID or Course Code is already in use. Please choose a unique value.");
        return false;
    }

    return true;
}