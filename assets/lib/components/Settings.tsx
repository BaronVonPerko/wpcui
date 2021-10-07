import { DatabaseObject } from "../models/models";
import { Component } from "react";
import React = require("react");
import ControlPrefixForm from "../forms/ControlPrefixForm";

interface IProps {
  data: DatabaseObject;
}

export default class Settings extends Component<IProps, null> {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <section>
        <h1>Settings</h1>

        <ControlPrefixForm />
      </section>
    );
  }
}