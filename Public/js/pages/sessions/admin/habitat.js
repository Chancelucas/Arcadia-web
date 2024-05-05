const submitButton = document.getElementById("habitat_btn_save");
const loadingDiv = document.getElementById("loading");

submitButton.addEventListener("click", async (e) => {
  e.preventDefault();
  loadingDiv.style.display = "block";

  const res = await fetch("/adminHabitat/createHabitat", {
    method: "POST",
    body: {
      headers: {
        "Content-Type": "application/json",
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
    },
  });

  // await new Promise((r) => setTimeout(r, 3000));
  // loadingDiv.style.display = "none";
  const data = await res.json();

  if (data.status === "error") {
    loadingDiv.innerHTML = data.description;
  } else {
    const email = data.user.email;
    loadingDiv.innerHTML = email;
  }

  console.log(res.ok);
  console.log(data);

  // location.reload();
});
