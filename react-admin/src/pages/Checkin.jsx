import React, { useState, useEffect } from "react";
import axios from "axios";

import Table from "../components/table/Table";

import { apiUrl } from '../context/Constants'

const checkinTableHead = ["checkin_id", "name", "lat", "long", "created_at"];

const renderHead = (item, index) => <th key={index}>{item}</th>;

const renderBody = (item, index) => {
  return (
    <tr key={index}>
      <td>{item.checkin_id}</td>
      <td>{item.name}</td>
      <td>{item.lat}</td>
      <td>{item.long}</td>
      <td>{item.created_at}</td>
    </tr>
  );
};
const Area_Active = () => {
  const [value, setValue] = useState(false);
  const [ckinlist, setCkinlist] = useState();

  async function fetchData() {
    const response = await axios.get(
      `${apiUrl}/admin/checkin/list`
    );
    setCkinlist(response.data.data);
    setValue(false);
  }

  useEffect(() => {
    fetchData();
  }, [value]);

  return (
    <div>
      <h2 className="page-header">Check in</h2>
      <div className="row">
        <div className="col-12">
          <div className="card">
            <div className="card__body">
              {ckinlist ? (
                <Table
                  limit="5"
                  headData={checkinTableHead}
                  renderHead={(item, index) => renderHead(item, index)}
                  bodyData={ckinlist}
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
  );
};

export default Area_Active;
