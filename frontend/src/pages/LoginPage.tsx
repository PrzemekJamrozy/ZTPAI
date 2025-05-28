import {useEffect, useState} from "react";
import styles from "../styles/CommonOnboarding.module.css";
import {FaEye, FaEyeSlash} from "react-icons/fa";
import {useForm} from "react-hook-form";
import {LoginForm} from "../common/Forms/LoginForm.ts";
import {action_auth_me, action_login} from "../common/actions/actions.ts";
import {Link, useNavigate} from "react-router";
import {useDispatch} from "react-redux";
import {setToken} from "../store/authSlice.ts";
import {useToast} from "../hooks/useToast.tsx";
import {setUser} from "../store/userSlice.ts";
import {UserStatusEnum} from "../common/enums/UserStatusEnum.ts";

function LoginPage() {
    const [showPassword, setShowPassword] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const toast = useToast();

    const {register, handleSubmit} = useForm<LoginForm>({
        defaultValues: {
            email: "",
            password: "",
        }
    });

    const handleLogin = async (data: LoginForm) => {
        toast("Trwa logowanie...", "info")
        const result = await action_login(data)

        if (result.success) {
            localStorage.setItem("token", result.data.token);
            const userResult = await action_auth_me()
            if (userResult.success) {
                dispatch(setUser(userResult.data))
                if (userResult.data.status === UserStatusEnum.DURING_REGISTRATION) {
                    navigate("/user/onboarding");
                } else {
                    navigate('/swiper')
                }
                // To prevent redirect from login to swiper set token only if redirection was already made by login component
                dispatch(setToken(result.data.token));
            } else {
                toast("Nie udało pobrać się danych użytkownika", "error");
            }
        } else {
            toast("Nieprawdłowe dane logowania", "error");
        }
    }

    useEffect(() => {
        document.body.classList.add(styles.commonOnboardingBody);
        return () => {
            document.body.classList.remove(styles.commonOnboardingBody);
        };
    }, []);

    return (
        <div className={styles.container}>
            <h1>Logowanie</h1>
            <form onSubmit={handleSubmit((data) => handleLogin(data))}>
                <div className={styles.formGroup}>
                    <label htmlFor="email">Email użytkownika</label>
                    <input type="text" id="email" {...register('email')} placeholder="Podaj email" required/>
                </div>
                <div className={`${styles.formGroup} ${styles.passwordWrapper}`}>
                    <label htmlFor="password">Hasło</label>
                    <input
                        type={showPassword ? "text" : "password"}
                        id="password"
                        {...register('password')}
                        placeholder="Podaj hasło"
                        required
                    />
                    <span
                        className={styles.passwordToggle}
                        onClick={() => setShowPassword(!showPassword)}
                    >
                        {showPassword ? <FaEyeSlash/> : <FaEye/>}
                    </span>
                </div>
                <button type="submit" className={styles.btnSubmit}>Zaloguj się</button>
            </form>
            <p>Nie masz konta? <Link to='/register'>Zarejestruj się</Link></p>
        </div>
    );
}

export {LoginPage};
