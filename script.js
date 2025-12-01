// Simulated user experiences
const userExperiences = [
  {
    name: "Fatou from Senegal",
    story: "Grand Popo was calm and beautiful! I met so many amazing locals.",
    image: "assets/fatou.jpg",
  },
  {
    name: "Amina from Kenya",
    story: "Agadez had the most beautiful architecture and friendly people.",
    image: "assets/amina.jpg",
  },
  {
    name: "Mohamed from Egypt",
    story: "The sunset in Morondava was breathtaking. Truly a lifetime memory!",
    image: "assets/mohamed.jpg",
  },
];

const userContainer = document.getElementById("user-experiences");

// Add each user experience with image + story
userExperiences.forEach((exp) => {
  const card = document.createElement("div");
  card.classList.add("experience-card");
  card.innerHTML = `
    <img src="${exp.image}" alt="${exp.name}" class="experience-img">
    <div class="experience-text">
      <h3>${exp.name}</h3>
      <p>${exp.story}</p>
    </div>
  `;
  userContainer.appendChild(card);
});
