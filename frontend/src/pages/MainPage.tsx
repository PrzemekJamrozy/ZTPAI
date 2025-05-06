import Landing from '../assets/landing.jpg'
import LandingTwo from '../assets/landing-two.jpg'
import styles from "../styles/MainPage.module.css"
import {useEffect} from "react";
import {Link} from "react-router";


function MainPage(){
    useEffect(()=>{
      document.body.classList.add(styles.mainPageBody)
      return () =>{
          document.body.classList.remove(styles.mainPageBody)
      }
    },[])

    return (
        <>
            <header className={styles.mainPageHeader}>DateSpark</header>
            <div className={styles.container}>
                <section className={styles.hero}>
                    <div>
                        <h1>Witaj na DateSpark!</h1>
                        <p>Znajdź swoją iskrę jednym kliknięciem. Bądź w społeczności ludzi dla których liczy się
                            związek na
                            dłużej</p>
                        <div className={styles.ctaButtons}>
                            <Link to='/register' className={styles.register}>Zarejestruj się</Link>
                            <Link to='/login' className={styles.login}>Zaloguj się</Link>
                        </div>
                    </div>
                </section>

                <section className={styles.imgContainer}>

                    <img src={Landing} alt="Find Your Spark"/>
                    <img src={LandingTwo} alt="Find Your Spark"/>

                </section>
            </div>

            <footer>
                &copy; 2025 DateSpark. All rights reserved.
            </footer>
        </>
    )
}

export {MainPage}