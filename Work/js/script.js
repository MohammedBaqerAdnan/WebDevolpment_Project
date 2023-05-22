document.addEventListener('DOMContentLoaded', async () => {
    try {
      const profileResponse = await fetch('get-user-profile.php');
      const profileData = await profileResponse.json();
      updateProfileUI(profileData);
      
      const resultsResponse = await fetch('get-user-results.php');
      const resultsData = await resultsResponse.json();
      updateResultsUI(resultsData);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  });
  
  function updateProfileUI(profile) {
    document.querySelector('.username').textContent = profile.username;
    document.querySelector('.email').textContent = profile.email;
    document.querySelector('.joined').textContent = profile.joined;
  }
  
  function updateResultsUI(results) {
    const resultsList = document.querySelector('.results-list');
  
    results.forEach(result => {
      const row = document.createElement('tr');
      
      row.innerHTML = `
        <td>${result.questionnaire}</td>
        <td>${result.date}</td>
        <td>${result.score}</td>
      `;
      
      resultsList.appendChild(row);
    });
  }