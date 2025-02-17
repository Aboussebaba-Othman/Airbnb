  const dateArrivee = document.getElementById("start_date");
  const dateDepart = document.getElementById("end_date");
  const nbNuits = document.getElementById("nb_nuits");

  // Fonction pour calculer le nombre de nuits
  function calculerNuits() {
    const arrivee = new Date(dateArrivee.value);
    const depart = new Date(dateDepart.value);

    // Vérification si les deux dates sont valides
    if (arrivee && depart && arrivee < depart) {
      const diffTime = depart - arrivee;
      const diffDays = diffTime / (1000 * 60 * 60 * 24); 
      nbNuits.textContent = diffDays;
    } else {
      nbNuits.textContent = 0;
    }
  }

  // Événements pour déclencher le calcul lors du changement des dates
  dateArrivee.addEventListener("change", calculerNuits);
  dateDepart.addEventListener("change", calculerNuits);