import React, { useState, useEffect } from "react";

import Table from "../components/table/Table";
import axios from "axios";
import { apiUrl } from '../context/Constants'
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

import EditkpidetailModal from "../components/modal/EditkpidetailModal";

import kpidetailList from "../assets/JsonData/kpi-detail-list.json";

const kpiTableHead = [
  "ID",
  "Tên học viên",
  "Bài test 1",
  "Bài test 2", "Tổng kết","Action"
];
const Kpi_Detail = () => {
  const [editmodalOpen, setEditmodalopen] = useState(false);
  const [kpilist, setKpilist] = useState([]);
  const [value, setValue] = useState(false);
  const [test1, setTest1] = useState(0);
  const [test2, setTest2] = useState(0);
  const [userId, setUserId] = useState(0);

  const openPopup = async (test1, test2, user_id) => {
    setEditmodalopen(!editmodalOpen);
    // setOrderAmount(order);
    setTest1(test1);
    setTest2(test2);
    setUserId(user_id);
  };

  async function fetchData() {
    setKpilist(null);
    const response = await axios.get(
      `${apiUrl}/admin/kpi/salesman`
    );
    setKpilist(response.data.data);
    setValue(false);
  }
  async function saveKpi(item) {
    console.log(item);
    // const response = await axios.get(
    //   `http://192.168.1.129:81/api/admin/kpi/save`,
    //   {
    //     "salesman_id": "USER00000003",
    //     "order_amount": 10,
    //     "checkin": 10
    //   }
    // );
    // setValue(!value);
  }

  const onChangeForm = (event, item) => {
    console.log(event.target, item);
    // setImage("");
    // var file = event.target.files[0];
    // setImage(file);
    // var reader = new FileReader();
    // reader.readAsDataURL(file);

    // reader.onloadend = function (e) {
    //   setImageprev(reader.result);
    // }.bind(this);
  };

  useEffect(() => {
    fetchData();
  }, [value]);
  const renderHead = (item, index) => <th key={index}>{item}</th>;

  const renderBody = (item, index) => {
    return (
      <tr key={index}>
        <td>{item.id}</td>
        <td>{item.name}</td>
        <td>{item.test_1}</td>
        <td>{item.test_2}</td>
        {/* <td>
          <input
            type="text"
            placeholder=""
            name="test_1"
            value={item.test_1}
            className="input-text"
            style={{ width: "150px" }}
            onChange={(e) => onChangeForm(e, item.test_2)}
          />
        </td>
         <td>
          <input
            type="text"
            placeholder=""
            className="input-text"
            name="test_2"
            value={item.test_2}
            style={{ width: "150px" }}
            onChange={(e) => onChangeForm(item, item.test_1)}
          />
        </td> */}
        <td>{item.total}</td>
       
        <td>
          <div className="cate-action">
            <div className="edit-action">
              <button
                onClick={() => {
                  openPopup(item.test_1, item.test_2, item.user_id);
                }}
              >
                <i
                  className="bx bx-edit"
                  style={{ fontSize: "20px", lineHeight: 1.5 }}
                />
              </button>
            </div>
            {/* <div className="save-action">
              <button onClick={() => saveKpi(item)}>
                <i
                  className="bx bx-save"
                  style={{ fontSize: "20px", lineHeight: 1.5 }}
                />
              </button>
            </div> */}
          </div>
        </td>
      </tr>
    );
  };
  return (
    <div>
      <div>
        <h2 className="page-header">Điểm học viên</h2>
        <div className="row">
          <div className="col-12">
            <div className="card">
              <div className="card__body">
                {kpilist && kpilist.length > 0 ? (
                  <Table
                    limit="5"
                    headData={kpiTableHead}
                    bodyData={kpilist}
                    renderHead={(item, index) => renderHead(item, index)}
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
        </div>  {editmodalOpen && (

          <EditkpidetailModal
          test_1={test1}
          test_2={test2}
          user_id={userId}  
            // salesmanId={salesmanId}
            setOpenModal={setEditmodalopen}
            setValue={setValue}
          />
        )} </div>

    </div>
  );
};

export default Kpi_Detail;
