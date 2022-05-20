import React, { useState, useEffect } from "react";

import Table from "../components/table/Table";
import axios from "axios";
import { apiUrl } from '../context/Constants'
import AddadminModal from "../components/modal/AddadminModal";
import { ToastContainer, toast } from "react-toastify";

// import { apiUrl, TOKEN } from "../../context/Constants";
// import setAuthToken from "../../redux/utils/setAuthToken";

const adminTableHead = [
  "ID",
  "name",
  "email",
  "address",
  "tel",
  "action",
];

const Admin = () => {
  const [adminlist, setAdminlist] = useState();
  const [value, setValue] = useState(false);

  async function fetchData() {
    setAdminlist(null);
    const response = await axios.get(`${apiUrl}/admin/list`);
    setAdminlist(response.data.data);
    setValue(false);
  }

  const renderHead = (item, index) => <th key={index}>{item}</th>;

  const renderBody = (item, index) => {
    return (
      <tr key={index}>
        <td>{item.id}</td>
        <td>{item.name}</td>
        <td>{item.email}</td>
        <td>{item.address}</td>
        <td>{item.tel}</td>
        <td>
          <div className="cate-action">
            <div className="delete-action">
              <button onClick={() => deladmin(item.id)}>
                <i
                  className="bx bx-trash"
                  style={{ fontSize: "20px", lineHeight: 1.5 }}
                />
              </button>
            </div>
          </div>
        </td>
      </tr>
    );
  };

  const deladmin = async (id) => {
    toast.dismiss();
    try {
      const res = await axios.post(
        `${apiUrl}/admin/user/delete/${id}`
      );
      if (res.data) {
        toast(res.data.message);
        setValue(true);
      }
    } catch (error) {
      toast(error.response.data.message);
    }
  };

  useEffect(() => {
    fetchData();
  }, [value]);

  const [addadminmodalOpen, setAddadminmodalOpen] = useState(false);

  const [isSupperAdmin, setIsSupperAdmin] = useState(false);

  const checkSupperAdmin = () => {
    const isAdmin = localStorage.getItem("isAdmin");
    if (isAdmin == 1) {
      setIsSupperAdmin(true);
    } else {
      window.location.href = "/";
    }
  };

  //   const checkLogin = async () => {
  //     if (localStorage[TOKEN]) {
  //       setAuthToken(localStorage[TOKEN]);
  //     }

  //     try {
  //       const response = await axios.get(`${apiUrl}/me`);
  //       const { data } = response;
  //       if (data.success) {
  //         setIsLogin(true);
  //       }
  //     } catch (error) {
  //       localStorage.removeItem(TOKEN);
  //       setAuthToken(null);
  //       setIsLogin(false);
  //       window.location.href = "/login";

  //     }
  //   };

  useEffect(() => {
    checkSupperAdmin();
  }, []);

  //   const checkSupperAdmin = () => {
  //     const isAdmin = localStorage.getItem("isAdmin");
  //     if (isAdmin !== 1) {
  //       window.location.href = "/"
  //     }
  //   };

  //   useEffect(() => {
  //     checkSupperAdmin();
  //   }, []);
  return (
    <>
      {isSupperAdmin ? (
        <div>
          <h2 className="page-header">Giảng viên</h2>
          <div className="row">
            <div className="col-12">
              <div className="card">
                <div className="card_header">
                  <div className="add-new-cate">
                    <button
                      onClick={() => {
                        setAddadminmodalOpen(!addadminmodalOpen);
                      }}
                    >
                      Thêm giảng viên
                    </button>
                  </div>
                </div>
                <div className="card__body">
                  {adminlist ? (
                    <Table
                      limit="5"
                      headData={adminTableHead}
                      renderHead={(item, index) => renderHead(item, index)}
                      bodyData={adminlist}
                      renderBody={(item, index) => renderBody(item, index)}
                    />
                  ) : (
                    <div className="w-100 text-center">
                      <div className="spinner-border text-dark" role="status"></div>
                    </div>
                  )}
                </div>
              </div>
            </div>
          </div>
        </div>
      ) : (
        ""
      )}
      {addadminmodalOpen && (
        <AddadminModal
          setOpenModal={setAddadminmodalOpen}
          setValue={setValue}
        />
      )}
      {/* <ToastContainer
        position="top-right"
        autoClose={3000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        rtl={false}
        pauseOnFocusLoss
        draggable
        pauseOnHover
      />
      <ToastContainer /> */}
    </>
  );
};

export default Admin;
