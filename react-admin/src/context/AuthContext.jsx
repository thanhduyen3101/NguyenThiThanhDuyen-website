import { createContext, useReducer, useEffect } from "react";
import { authReducers } from "../redux/reducers/authReducers";
import axios from "axios";
import { apiUrl, TOKEN } from "./Constants";
import setAuthToken from "../redux/utils/setAuthToken";

export const AuthContext = createContext();

const AuthContextProvider = ({ children }) => {

  const [authState, dispatch] = useReducer(authReducers, {
    authLoading: true,
    isAuthenticated: false,
    user: null,
  });

  //Authenticate user

  // const loadUser = async () => {
  //   if (localStorage[TOKEN]) {
  //     setAuthToken(localStorage[TOKEN]);
  //   }

  //   try {
  //     const response = await axios.get(`${apiUrl}/auth/checktoken`);
  //     const { data } = response;
  //     if (data.success) {
  //       dispatch({
  //         type: "SET_AUTH",
  //         payload: { isAuthenticated: true, user: response.data.user },
  //       });
  //     }
  //   } catch (error) {
  //     localStorage.removeItem(TOKEN);
  //     setAuthToken(null);
  //     dispatch({
  //       type: "SET_AUTH",
  //       payload: { isAuthenticated: false, user: null },
  //     });
  //   }
  // };
  const clearAllData = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("isAdmin");
    localStorage.removeItem("isTeacher");
  };
  useEffect(() => clearAllData(), []);

  //Login

  const loginUser = async (userForm) => {
    try {
      const response = await axios.post(`${apiUrl}/auth/admin/login`, userForm);
      if (response.data.success) {
        console.log('response', response);
        if (response.data.data.type_id === "ADM") {
          const { data } = response.data;
          localStorage.setItem(TOKEN, data.token);
          localStorage.setItem("isAdmin", data.admin);
          setAuthToken(localStorage[TOKEN]);
          dispatch({
            type: "SET_AUTH",
            payload: { isAuthenticated: true, user: response.data.user },
          });
          //   await loadUser();
        } else {
        }
      }

      return response.data;
    } catch (error) {
      if (error.response.data) return error.response.data;
      else return { success: false, message: error.message };
    }
  };
  const logoutUser = () => {
    localStorage.removeItem(TOKEN);
    dispatch({
      type: "SET_AUTH",
      payload: { isAuthenticated: false, user: null },
    });
  };

  //Context data
  const AuthContextdata = { loginUser, logoutUser, authState };

  return (
    <AuthContext.Provider value={AuthContextdata}>
      {children}
    </AuthContext.Provider>
  );
};

export default AuthContextProvider;
