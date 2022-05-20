import React, { useState, useEffect } from "react";

import axios from "axios";
import { apiUrl } from '../context/Constants'
import Table from "../components/table/Table";

import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const Kpi = () => {
  const [value, setValue] = useState(false);
  const [kpi, setKpi] = useState();

  const kpiTableHead = [
    "ID",
    "Tên học viên",
    "Bài kiểm tra 1",
    "Bài kiểm tra 2",
    "Tổng kết",
    "Thao tác",
  ];
  // const [value, setValue] = useState(false);

  const renderHead = (item, index) => <th key={index}>{item}</th>;

  async function fetchData() {
    setKpi(null);
    const response = await axios.get(
      `${apiUrl}/admin/kpi/list`
    );
    setKpi(response.data.data);
    setValue(false);
  }

  async function deleteKpi(kpi_id) {
    toast.dismiss();
    await axios
      .post(`${apiUrl}/admin/kpi/delete/${kpi_id}`)
      .then(async (response) => {
        if (response.data.success) {
          toast(response.data.message);
          setValue(true);

          // await fetchData();
          //   const response = await axios.get(
          //     `http://192.168.1.129:81/api/admin/kpi/list`
          //   );
          //   setKpi(kpi => ([...kpi, ...response.data.data]));
        } else {
          toast(response.data.message);
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

  const renderBody = (item, index) => {
    return (
      <tr>
        <td>{item.id}</td>
        <td>{item.name}</td>
        <td>{item.test_1}</td>
        <td>{item.test_2}</td>
        <td>{item.total}</td>
        <td>
          <div className="cate-action">
            <div className="delete-action">
              <button
                onClick={() => {
                  deleteKpi(item.id);
                }}
              >
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

  useEffect(() => {
    fetchData();
  }, [value]);
  return (
    <div>
      <h2 className="page-header">Điểm học viên</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card_header">
              <div className="add-new-cate">
                <button
                  onClick={() => {
                    window.location.href = "/admin/score_detail";
                  }}
                >
                  Điểm học viên
                </button>
              </div>
            </div>
            <div className="card__body">
              {kpi ? (
                <Table
                  limit="5"
                  headData={kpiTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={kpi}
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
};

export default Kpi;
