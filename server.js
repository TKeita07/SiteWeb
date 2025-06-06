const express = require('express');
const nodemailer = require('nodemailer');
const multer = require('multer');
const bodyParser = require('body-parser');
const cors = require('cors');
const upload = multer({ dest: 'uploads/' }); // dossier temporaire de stockage

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// Route pour le formulaire
app.post('/send', upload.array('fichiers'), async (req, res) => {
  const { nom, prenom, email, telephone, materiel, couleur, dimension, epaisseur, message } = req.body;

  const transporter = require('nodemailer').createTransport({
      service: 'gmail', // fonctionne aussi avec 'hotmail' mais Outlook365 est plus fiable
      auth: {
          user: 'thomas.keita.00@gmail.com',
          pass: 'efpj qqyl ykrw cfvs' // ou mot de passe simple si 2FA est désactivée
      }
  });
  
  // Génère une liste des fichiers en pièce jointe
  const attachments = req.files.map(file => ({
    filename: file.originalname,
    path: file.path
  }));



  const mailOptions = {
    from: email,
    to: 'thomas.keita@hotmail.com',
    subject: `Nouveau message de ${nom}`,
      html: `
        <h2>Nouvelle demande de devis</h2>
        <p><strong>Nom :</strong> ${nom}</p>
        <p><strong>Prénom :</strong> ${prenom}</p>
        <p><strong>Email :</strong> ${email}</p>
        <p><strong>Téléphone :</strong> ${telephone}</p>
        <hr>
        <p><strong>Matériel :</strong> ${materiel}</p>
        <p><strong>Couleur :</strong> ${couleur}</p>
        <p><strong>Dimension :</strong> ${dimension}</p>
        <p><strong>Épaisseur :</strong> ${epaisseur}</p>
        <hr>
        <p><strong>Message :</strong><br>${message.replace(/\n/g, '<br>')}</p>
      `,
    attachments: attachments

  };

  const accuseMailOptions = {
  from: 'thomas.keita@hotmail.com',
  to: email,
  subject: `Demande de devis reçue`,
    html: `Votre demande de devis a bien été reçue.
      <p>Nous vous contacterons bientôt pour discuter de votre demande.</p>
    `
  };

  try {
    await transporter.sendMail(mailOptions);
    await transporter.sendMail(accuseMailOptions);
    res.send('Emails envoyé avec succès !');
  } catch (error) {
    console.error('Erreur d’envoi :', error);
    res.status(500).send('Erreur lors de l’envoi de l’email.');
  }


});

app.listen(PORT, () => {
  console.log(`Serveur démarré sur http://localhost:${PORT}`);
});
