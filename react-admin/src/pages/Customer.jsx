import React, { useState, useEffect } from "react";

import axios from "axios";

import Table from "../components/table/Table";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

import { apiUrl } from '../context/Constants';

import AddcusModal from '../components/modal/AddcusModal';

const Customer = () => {
  const [value, setValue] = useState(false);
  const [loading, setLoading] = useState(false);
  const [listcustomer, setListcustomer] = useState();

  const [addmodalOpen, setaddmodalOpen] = useState(false);

  const customerTableHead = [
    "ID",
    "Tên giảng viên",
    "Email",
    "SĐT",
    "Trình độ", 
    "Thao tác"
  ];

  const renderHead = (item, index) => <th key={index}>{item}</th>;

  async function fetchData() {
    setListcustomer(null);
    const response = await axios.get(`${apiUrl}/admin/teacher/list`);
    setListcustomer(response.data.data);
    setValue(false);
  }
  

  const renderBody = (item, index) => {
    return (
      <tr key={index}>
        <td>{item.user_id}</td>
        <td style={{ textAlign: "left" }}>{item.name}</td>
        <td style={{ textAlign: "left", textTransform: "lowercase" }}>{item.email}</td>
        <td>{item.tel}</td>
        <td style={{ textAlign: "left" }}>{item.address}</td>
        <><div className="delete-action" style={{marginLeft: "25px", paddingTop: "9px"}}>
            <button onClick={()=>deleteCate(item.id)}
                >
              <i className="bx bx-trash" style={{ fontSize: "20px",lineHeight: 1.5}} />
            </button>
          </div></>
      </tr>
    );
  };

  async function deleteCate(id) {
    await axios
      .post(`${apiUrl}/admin/user/delete/${id}`)
      .then(async (response) => {
        toast(response.data.message);
        if (response.data.success) {
          setValue(true);
        }
      })
      .catch((error) => {
        if (error.response) {
          toast(error.response.data.message);
        } else {
          toast("Error");
        }
      });
  }

  useEffect(() => {
    const isTeacher = localStorage.getItem("isTeacher");
    if (isTeacher == 1) {
      window.location.href = '/admin/users';
    }
    fetchData();
  }, [value]);
  return (
    <>
    <div>
      <h2 className="page-header">Giảng viên</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            {/* Hereeeeeeeee */}
            <div className="add-new-cate">
              <button
                onClick={() => {
                  setaddmodalOpen(!addmodalOpen);
                }}
              >
                Thêm giảng viên
              </button>
            </div>
            <div className="card__body">
              {listcustomer ? (
                <Table
                  limit="10"
                  headData={customerTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={listcustomer}
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
      <ToastContainer
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
      {/* Same as */}
      <ToastContainer />
    </div>

    {addmodalOpen && (
      <AddcusModal setOpenModal={setaddmodalOpen} setValue={setValue}/>
    )}            
    </>
  );
};

export default Customer;
