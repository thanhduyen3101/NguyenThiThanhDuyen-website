import React, { useEffect, useState } from "react";

import "./modal.css";
import axios from "axios";
import { apiUrl } from '../../context/Constants'
import { ToastContainer, toast } from "react-toastify";

function EditkpidetailModal({
  setOpenModal,
  user_id,
  test_1,
  test_2,
  setValue,
}) {
  const [test1, setTest1] = useState(test_1);
  const [test2, setTest2] = useState(test_2);
  const [userId, setUserId] = useState(user_id);
  const [data, setData] = useState({
    student_id: userId,
    test_1: test1,
    test_2: test2,
  });



  // const calcTotal = () => { 
  //   debugger;
  //   const totalScore = test1 + test2;
  //   setTotal(totalScore);
  // };

  const onChangeInput = (event) => {
    setData({ ...data, [event.target.name]: event.target.value });
  };
  const saveKpi = async () => {
    const response = await axios
      .post(`${apiUrl}/admin/kpi/save`, data)
      .then((response) => {
        setValue(true);
        toast(response.data.message);
        // if (response.data.success) {
        //   toast(response.data.message);
        // } else {
        //   toast(response.data.message);
        // }
        setTimeout(() => {
          setOpenModal(false);
        }, 2000);
      })
      .catch((error) => {
        if (error.response) {
          toast(error.response.data.message);
        } else {
          toast("Error");
        }
        setTimeout(() => {
          setOpenModal(false);
        }, 2000);
      });
  };



  return (
    <div className="modalBackground">
      <div className="modalContainer-score">
        <span
          className="close-icon"
          onClick={() => {
            setOpenModal(false);
          }}
        >
          &times;
        </span>
        <h2 style={{ color: "#202020" }}>Sửa điểm học viên </h2>
        <input
          type="text"
          placeholder=""
          className="input-text"
          name="test_1"
          value={data.test_1}
          onChange={onChangeInput}
        />
        <input
          type="text"
          placeholder=""
          className="input-text"
          name="test_2"
          value={data.test_2}
          onChange={onChangeInput}
        />

        <div className="modalFooter">
          <button
            className="button-edit"
            onClick={() => {
              saveKpi();
            }}
          >
            Hoàn tất
          </button>
          <button
            className="button-delete"
            onClick={() => {
              setOpenModal(false);
            }}
            id="cancelBtn"
          >
            Hủy
          </button>
        </div>
      </div>
      {/* <ToastContainer
        position="top-right"
        autoClose={2000}
        hideProgressBar={false}
        newestOnTop={false}
        closeOnClick
        rtl={false}
        pauseOnFocusLoss
        draggable
        pauseOnHover
      />
      <ToastContainer /> */}
    </div>
  );
}

export default EditkpidetailModal;
