async function init() {
  try {
    const response = await fetch("/api/gallery");
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const data = await response.json();

    currentEvents = data;
    renderEvents(currentEvents);
    initializeGridMotion();
  } catch (error) {
    console.error("Failed to load gallery events:", error);
    eventsGrid.style.display = "none";
    noResults.style.display = "block";
    noResults.textContent = "Failed to load gallery events.";
  }
}

// Global state
let currentEvents = [];
let currentImageIndex = 0;
let currentEventImages = [];
let currentEventDescriptions = [];

// DOM elements
const eventsGrid = document.getElementById("eventsGrid");
const noResults = document.getElementById("noResults");
const imageModal = document.getElementById("imageModal");
const closeModal = document.getElementById("closeModal");
const modalTitle = document.getElementById("modalTitle");
const modalDomain = document.getElementById("modalDomain");
const imageLoader = document.getElementById("imageLoader");
const imageContent = document.getElementById("imageContent");
const mainImage = document.getElementById("mainImage");
const imageDescription = document.getElementById("imageDescription");
const thumbnailsContainer = document.getElementById("thumbnailsContainer");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

// Utility functions
function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}

function parseImageData(imageUrls, descriptions) {
  const urls = imageUrls.split("&").filter((url) => url.trim());
  const descs = descriptions.split("&").filter((desc) => desc.trim());
  return { urls, descs };
}

// Grid Motion functionality
function initializeGridMotion() {
  const gridRows = document.querySelectorAll(".grid-row");
  let mouseX = window.innerWidth / 2;

  // Update mouse position
  window.addEventListener("mousemove", (e) => {
    mouseX = e.clientX;
  });

  // Animation loop
  function updateGridMotion() {
    const maxMoveAmount = 300;
    const baseDuration = 0.8;
    const inertiaFactors = [0.6, 0.4, 0.3, 0.2];

    gridRows.forEach((row, index) => {
      const direction = index % 2 === 0 ? 1 : -1;
      const moveAmount =
        ((mouseX / window.innerWidth) * maxMoveAmount - maxMoveAmount / 2) *
        direction;

      row.style.transform = `translateX(${moveAmount}px)`;
      row.style.transition = `transform ${baseDuration + inertiaFactors[index % inertiaFactors.length]}s cubic-bezier(0.4, 0, 0.2, 1)`;
    });

    requestAnimationFrame(updateGridMotion);
  }

  updateGridMotion();
}

// Render functions

function renderEventCard(event) {
  const baseURL = `${window.location.origin}`;

  return `
        <div class="event-card" onclick="openModal('${event.GalleryId}')">
            <img src="${baseURL}${event.GalleryImageBanner}" alt="${event.GalleryName}" class="event-image">
            <div class="event-content">
                <h3 class="event-title">${event.GalleryName}</h3>
                <p class="event-date">${formatDate(event.GalleryDate)}</p>
                <p class="event-description">${event.GalleryDescription.substring(0, 120)}...</p>
                <span class="event-domain">${event.GalleryDomain}</span>
            </div>
        </div>
    `;
}

function renderEvents(events) {
  if (events.length === 0) {
    eventsGrid.style.display = "none";
    noResults.style.display = "block";
  } else {
    eventsGrid.style.display = "grid";
    noResults.style.display = "none";
    eventsGrid.innerHTML = events.map(renderEventCard).join("");
  }
}

function renderThumbnails() {
  const baseURL = `${window.location.origin}`;
  console.log(baseURL);
  console.log(currentEventImages);
  thumbnailsContainer.innerHTML = currentEventImages
    .map(
      (url, index) => `
        <div class="thumbnail ${index === currentImageIndex ? "active" : ""}" onclick="selectImage(${index})">
            <img src="${baseURL}${url}" alt="Thumbnail ${index + 1}">
        </div>
    `,
    )
    .join("");
}

function openModal(eventId) {
  console.log(eventId);
  const event = currentEvents.find((e) => e.GalleryId == eventId);
  console.log(currentEvents);
  if (!event) return;

  modalTitle.textContent = event.GalleryName;
  modalDomain.textContent = event.GalleryDomain;

  imageModal.style.display = "flex";
  document.body.style.overflow = "hidden";

  // Show loader while images are loading
  imageLoader.style.display = "flex";
  imageContent.style.display = "none";

  // ✅ Fixed: Correct property names

  const { urls, descs } = parseImageData(
    event.GalleryImagesUrl,
    event.GalleryImageDescription,
  );

  // Optional safety fallback
  currentEventImages = Array.isArray(urls) ? urls : [];
  currentEventDescriptions = Array.isArray(descs) ? descs : [];
  currentImageIndex = 0;

  // Simulate loading delay (can be removed in production)
  setTimeout(() => {
    loadImages();
  }, 1000);
}

function closeModalHandler() {
  imageModal.style.display = "none";
  document.body.style.overflow = "auto";
  currentEventImages = [];
  currentEventDescriptions = [];
  currentImageIndex = 0;
}

function loadImages() {
  if (currentEventImages.length === 0) {
    imageLoader.innerHTML = "<p>No images available</p>";
    return;
  }

  imageLoader.style.display = "none";
  imageContent.style.display = "block";

  displayCurrentImage();
  renderThumbnails();
}

function displayCurrentImage() {
  if (currentEventImages.length === 0) return;

  mainImage.src = currentEventImages[currentImageIndex];
  mainImage.alt = `Image ${currentImageIndex + 1}`;

  const description =
    currentEventDescriptions[currentImageIndex] || "No description available";
  imageDescription.textContent = description;

  // Update navigation buttons
  prevBtn.style.display = currentEventImages.length > 1 ? "block" : "none";
  nextBtn.style.display = currentEventImages.length > 1 ? "block" : "none";

  renderThumbnails();
}

function selectImage(index) {
  currentImageIndex = index;
  displayCurrentImage();
}

function navigateImage(direction) {
  if (currentEventImages.length <= 1) return;

  if (direction === "prev") {
    currentImageIndex =
      currentImageIndex > 0
        ? currentImageIndex - 1
        : currentEventImages.length - 1;
  } else {
    currentImageIndex =
      currentImageIndex < currentEventImages.length - 1
        ? currentImageIndex + 1
        : 0;
  }

  displayCurrentImage();
}

// Event listeners
closeModal.addEventListener("click", closeModalHandler);
prevBtn.addEventListener("click", () => navigateImage("prev"));
nextBtn.addEventListener("click", () => navigateImage("next"));

// Close modal on overlay click
imageModal.addEventListener("click", (e) => {
  if (e.target === imageModal || e.target.classList.contains("modal-overlay")) {
    closeModalHandler();
  }
});

// Keyboard navigation
document.addEventListener("keydown", (e) => {
  if (imageModal.style.display === "flex") {
    switch (e.key) {
      case "Escape":
        closeModalHandler();
        break;
      case "ArrowLeft":
        navigateImage("prev");
        break;
      case "ArrowRight":
        navigateImage("next");
        break;
    }
  }
});

// Start the application when DOM is loaded
document.addEventListener("DOMContentLoaded", init);
