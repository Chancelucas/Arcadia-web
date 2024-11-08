# RESTE A FAIRE !

## PAGE ADMINISTRATION

Un Admin peut tout faire (ou presque).

Un vétérinaire peut créer des comptes rendus sur les habitats et les animaux.

un employé peut nourrir des animaux, modifier les services et valider les avis des internautes.

### **Dashboard**

[Dashboard administrateur](://localhost:8888/adminDashboard)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

- Nombre de consultation par animal ❌
- Accés protégé (auth) ✅
  - Uniquement l'admin peut accéder à cette page  ✅

---

[Dashboard Vétérinaire](://localhost:8888/vetDashboard)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✔️     |
| Employé      |    ✖️     |

- -R-- sur les nourrissage des animaux (en **LECTURE** uniquement) ✅
- Accés protégé (auth) ✅
  - Uniquement le vétérinaire peut accéder à cette page ✅

---

[Dashboard Employé](://localhost:8888/employeeDashboard)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✔️     |

- -RU- sur les avis des internautes ✅
- Accés protégé (auth) ✅
  - Uniquement l'employé peut accéder à cette page ✅

### Salariés

[lien](://localhost:8888/adminUser)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

| Type de user | CRUD |
| :----------- | :--: |
| Admin        | -R-- |
| Vétérinaire  | CRUD |
| Employé      | CRUD |

- CRUD sur les users ✅
- Il ne peut pas être possible de modifier / créer / supprimer un admin ✅
- Accés protégé (auth) ✅
  - Uniquement l'admin peut accéder à cette page ✅

### Habitats

[lien](://localhost:8888/adminHabitat)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

- CRUD sur les habitats ✅
- Gestion des images sur cloudinary ✅
- Suppression d'un habitat ✅
  - Un habitat ne peut pas être supprimé si il y a encore un animal ❓
  - Si un habitat est supprimé, alors vide sa liste d'animaux ❓
- Accés protégé (auth) ✅
  - Uniquement l'admin peut accéder à cette page ✅

### Animaux

[lien](://localhost:8888/adminAnimal)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

- CRUD sur les animaux ✅
- Gestion des images sur cloudinary ✅
- Accés protégé (auth) ✅
  - Uniquement l'admin peut accéder à cette page ✅

### Services

[Services Administrateur](://localhost:8888/adminService)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

- CRUD sur les services ✅
- Gestion des images sur cloudinary ✅
- Accés protégé (auth) ✅
  - Uniquement l'admin peut accéder à cette page ✅

---

[Services Employé](://localhost:8888/employeeService)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✔️     |

- -RU- sur les services ✅
- Gestion des images sur cloudinary ✅
- Accés protégé (auth) ✅
  - Uniquement l'employé peut accéder à cette page ✅

### Horaires

[lien](://localhost:8888/adminHour)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

- CRUD sur les services ✅
- Contrôle sur cohérence heure d'ouverture et heure de fermeture (Hardening)
  - Le jour est unique ✅
  - horaire fermeture > horaire de début ✅
- Accés protégé (auth) ✅
  - Uniquement l'admin peut accéder à cette page ✅

### Comptes rendus

[Comptes rendus administrateur](://localhost:8888/adminReport)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✔️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✖️     |

- -R-- sur les comptes rendus animaux (en **LECTURE** uniquement)  ✅
- -R-- sur les comptes rendus habitats (en **LECTURE** uniquement)  ✅
- Permettre de filter :
  - par date ✅
  - par race d'animal ✅
  - par habitat ✅

---

[Comptes rendus vétérinaire](://localhost:8888/vetReport)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✔️     |
| Employé      |    ✖️     |

- C--- sur les comptes rendus des habitats ✅
- C--- sur les comptes rendus des animaux ✅
- Accés protégé (auth) ✅
  - Uniquement le vétérinaire peut accéder à cette page ✅

---

[Comptes rendus vétérinaire des habitats](://localhost:8888/vetHabitat)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✔️     |
| Employé      |    ✖️     |

- -RUD sur les comptes rendus des habitats ✅ (bug sur les états)
- Accés protégé (auth) ✅
  - Uniquement le vétérinaire peut accéder à cette page ✅

---

[Comptes rendus vétérinaire des animaux](://localhost:8888/vetAnimal)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✔️     |
| Employé      |    ✖️     |

- -RUD sur les comptes rendus des animaux ✅ (bug sur les états)
- Accés protégé (auth) ✅
  - Uniquement le vétérinaire peut accéder à cette page ✅

---

[Nourissage d'animaux](://localhost:8888/employeeAnimalFeed)

| Type de user | A accès ? |
| :----------- | :-------: |
| Admin        |    ✖️     |
| Vétérinaire  |    ✖️     |
| Employé      |    ✔️     |

- Accés protégé (auth) ✅
  - Uniquement l'employé peut accéder à cette page ✅

## FRONT USER


