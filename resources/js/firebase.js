// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getStorage } from "firebase/storage";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyD-X_WU_Yl3pZkJhr_DyLP4GVywUwpuBmM",
  authDomain: "studenttrip-2cda2.firebaseapp.com",
  projectId: "studenttrip-2cda2",
  storageBucket: "studenttrip-2cda2.appspot.com",
  messagingSenderId: "695063927116",
  appId: "1:695063927116:web:1c71fef0f67fc892bdd7e9",
  measurementId: "G-GGSQZ0HG9Z"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);