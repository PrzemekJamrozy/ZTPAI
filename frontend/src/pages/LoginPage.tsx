import { useEffect, useState } from "react";
import styles from "../styles/CommonOnboarding.module.css";
import { FaEye, FaEyeSlash } from "react-icons/fa";
import {useForm} from "react-hook-form";
import {LoginForm} from "../common/Forms/LoginForm.ts";
import {action_login} from "../common/actions/actions.ts";
import {Link, useNavigate} from "react-router";
import {useDispatch} from "react-redux";
import {setToken} from "../store/authSlice.ts";

function LoginPage() {
    const [showPassword, setShowPassword] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const {register, handleSubmit} = useForm<LoginForm>({
        defaultValues: {
            email:"",
            password:"",
        }
    });

    const handleLogin = async (data:LoginForm) =>  {
        const result = await action_login(data)

        if(result.success){
            localStorage.setItem("token",result.data.token);
            dispatch(setToken(result.data.token));
            navigate('/swiper')
        }else{
            console.log("login fail")
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
                    <input type="text" id="email" {...register('email')} placeholder="Podaj email" required />
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
                        {showPassword ? <FaEyeSlash /> : <FaEye />}
                    </span>
                </div>
                <button type="submit" className={styles.btnSubmit}>Zaloguj się</button>
            </form>
            <p>Nie masz konta? <Link to='/register'>Zarejestruj się</Link></p>
        </div>
    );
}

export { LoginPage };
