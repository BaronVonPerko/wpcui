import { Component } from "react";
import React = require("react");

interface IconButton {
  function: Function;
  title: string;
}

interface IProps {
  onDuplicate?: IconButton;
  onEdit?: IconButton;
  onDelete?: IconButton;
}

export default class ItemPanelHeader extends Component<IProps, {}> {
  renderHeaderButtons() {
    const buttons = [];
    if (this.props.onDuplicate) {
      buttons.push(
        <i
          key="duplicateIcon"
          title={this.props.onDuplicate.title}
          onClick={() => this.props.onDuplicate.function}
          className="dashicons dashicons-admin-page"
        />
      );
    }
    if (this.props.onEdit) {
      buttons.push(
        <i
          key="editIcon"
          title={this.props.onEdit.title}
          onClick={() => this.props.onEdit.function()}
          className="dashicons dashicons-edit"
        />
      );
    }
    if (this.props.onDelete) {
      buttons.push(
        <i
          key="deleteIcon"
          title={this.props.onDelete.title}
          onClick={() => this.props.onDelete.function()}
          className="dashicons dashicons-trash"
        />
      );
    }

    return buttons;
  }

  render() {
    return (
      <div className="wpcui-section-headerbar">
        {this.renderHeaderButtons()}
      </div>
    );
  }
}
