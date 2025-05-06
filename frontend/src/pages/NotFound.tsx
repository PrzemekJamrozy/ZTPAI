import styles from "../styles/Error404.module.css"
import brokenHearth from "../assets/broken-heart.png"
import {Link} from "react-router";
import {useEffect} from "react";

function NotFound(){

    useEffect(()=>{
        document.body.classList.add(styles.error404Body)
        return () =>{
            document.body.classList.remove(styles.error404Body)
        }
    },[])

    return (
        <>
            <div className={styles.container}>
                <h1>404</h1>
                <h2>Nie znaleziono strony</h2>
                <p>
                    Strona mogła zostać usunięta, jej nazwa mogła się zmienić, lub jest chwilowo niedostępna.
                </p>
                <Link to='/' className={styles.button}>Wróć do ekranu głównego</Link>
                <div className={styles.illustration}>
                    <img src={brokenHearth} alt="404 Illustration"/>
                </div>
            </div>
        </>
    );
}

export {NotFound};