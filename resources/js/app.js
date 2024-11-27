import './bootstrap';
import 'preline';
document.addEventListener('livewire:navigated', () => {
    window.HSStaticMethods.autoInit();
})
  // Get elements
  const filterIcon = document.getElementById('filterIcon');
  const filterOverlay = document.getElementById('filterOverlay');
  const closeFilter = document.getElementById('closeFilter');
  const userIcon = document.getElementById('userIcon');
  const userMenu = document.getElementById('userMenu');

  // Toggle filter overlay
  filterIcon.addEventListener('click', () => {
      filterOverlay.classList.toggle('hidden');
  });

  // Close filter overlay
  closeFilter.addEventListener('click', () => {
      filterOverlay.classList.add('hidden');
  });

  // Toggle user profile menu
  userIcon.addEventListener('click', () => {
    console.log('masuk')
      userMenu.classList.toggle('hidden');
  });

  // Close user profile menu if clicked outside
  document.addEventListener('click', (event) => {
      if (!userIcon.contains(event.target) && !userMenu.contains(event.target)) {
          userMenu.classList.add('hidden');
      }
      if (!filterIcon.contains(event.target) && !filterOverlay.contains(event.target)) {
          filterOverlay.classList.add('hidden');
      }
  });