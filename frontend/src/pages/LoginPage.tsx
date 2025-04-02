import { useEffect, useState } from "react";
import styles from "../styles/CommonOnboarding.module.css";
import { FaEye, FaEyeSlash } from "react-icons/fa";

function LoginPage() {
    const [showPassword, setShowPassword] = useState(false);

    useEffect(() => {
        document.body.classList.add(styles.commonOnboardingBody);
        return () => {
            document.body.classList.remove(styles.commonOnboardingBody);
        };
    }, []);

    return (
        <div className={styles.container}>
            <h1>Logowanie</h1>
            <form>
                <div className={styles.formGroup}>
                    <label htmlFor="email">Email użytkownika</label>
                    <input type="text" id="email" name="email" placeholder="Podaj email" required />
                </div>
                <div className={`${styles.formGroup} ${styles.passwordWrapper}`}>
                    <label htmlFor="password">Hasło</label>
                    <input
                        type={showPassword ? "text" : "password"}
                        id="password"
                        name="password"
                        placeholder="Podaj hasło"
                        required
                    />
                    <span
                        className={styles.passwordToggle}
                        onClick={() => setShowPassword(!showPassword)}
                    >
                        {showPassword ? <FaEyeSlash /> : <FaEye />}
                    </span>
                </div>
                <button type="submit" className={styles.btnSubmit}>Zaloguj się</button>
            </form>
            <p>Nie masz konta? <a href="/register">Zarejestruj się</a></p>
        </div>
    );
}

export { LoginPage };
