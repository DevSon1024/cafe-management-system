#!/usr/bin/env python3
"""
Data Flow Diagram Generator for Cafe Management System (MVC Architecture)
This script uses the graphviz library to create a DFD showing data flow 
between components in a Model-View-Controller architecture.
"""

import graphviz
import os

def create_cafe_mvc_dfd():
    """
    Creates a Data Flow Diagram for Cafe Management System using MVC architecture.
    
    Returns:
        graphviz.Digraph: The configured graph object
    """
    
    # Create a new directed graph with TB (top-to-bottom) orientation
    dfd = graphviz.Digraph(
        name='Cafe_Management_MVC_DFD',
        comment='Cafe Management System - MVC Data Flow Diagram',
        format='png'  # Can be changed to 'svg' if preferred
    )
    
    # Set global graph attributes
    dfd.attr(rankdir='TB')  # Top-to-bottom orientation
    dfd.attr('graph', fontname='Lato', fontsize='12', bgcolor='white')
    dfd.attr('node', fontname='Lato', fontsize='10')
    dfd.attr('edge', fontname='Lato', fontsize='9')
    
    # Define nodes with their respective shapes and colors
    
    # External Entity - User
    dfd.node(
        'User',
        'User\n(Admin/Chef/Cashier)',
        shape='box',
        style='filled',
        fillcolor='#6F4E37',  # Coffee Brown
        fontcolor='white',
        width='1.5'
    )
    
    # Process - Web Browser (View)
    dfd.node(
        'View',
        'Web Browser\n(View)',
        shape='ellipse',
        style='filled',
        fillcolor='#87CEEB',  # Sky Blue for View
        fontcolor='black',
        width='1.5'
    )
    
    # Process - Controller
    dfd.node(
        'Controller',
        'Controller\n(Handles Requests)',
        shape='ellipse',
        style='filled',
        fillcolor='#4A90A4',  # Soft Blue
        fontcolor='white',
        width='1.5'
    )
    
    # Process - Model
    dfd.node(
        'Model',
        'Model\n(Data Logic)',
        shape='ellipse',
        style='filled',
        fillcolor='#4A90A4',  # Soft Blue
        fontcolor='white',
        width='1.5'
    )
    
    # Data Store - Database
    dfd.node(
        'Database',
        'Database\n(Cafe Data)',
        shape='cylinder',
        style='filled',
        fillcolor='#A9A9A9',  # Dark Gray
        fontcolor='white',
        width='1.5'
    )
    
    # Define data flows (edges) with labels
    
    # User to View
    dfd.edge(
        'User', 'View',
        label='Makes a Request',
        color='#333333',
        arrowhead='normal'
    )
    
    # View to Controller
    dfd.edge(
        'View', 'Controller',
        label='HTTP Request',
        color='#333333',
        arrowhead='normal'
    )
    
    # Controller to Model
    dfd.edge(
        'Controller', 'Model',
        label='Fetches/Updates Data',
        color='#333333',
        arrowhead='normal'
    )
    
    # Model to Database
    dfd.edge(
        'Model', 'Database',
        label='SQL Query',
        color='#333333',
        arrowhead='normal'
    )
    
    # Database to Model
    dfd.edge(
        'Database', 'Model',
        label='Returns Data',
        color='#333333',
        arrowhead='normal'
    )
    
    # Model to Controller
    dfd.edge(
        'Model', 'Controller',
        label='Passes Data',
        color='#333333',
        arrowhead='normal'
    )
    
    # Controller to View
    dfd.edge(
        'Controller', 'View',
        label='Loads View with Data',
        color='#333333',
        arrowhead='normal'
    )
    
    # View to User
    dfd.edge(
        'View', 'User',
        label='Displays HTML Page',
        color='#333333',
        arrowhead='normal'
    )
    
    return dfd

def main():
    """
    Main function to create and render the DFD.
    """
    
    try:
        # Create the DFD
        print("Creating Cafe Management System MVC Data Flow Diagram...")
        dfd = create_cafe_mvc_dfd()
        
        # Set output directory (current directory by default)
        output_dir = os.getcwd()
        output_filename = 'cafe_management_mvc_dfd'
        
        # Render the diagram
        dfd.render(
            filename=output_filename,
            directory=output_dir,
            cleanup=True,  # Remove the intermediate .dot file
            view=False     # Set to True to automatically open the file
        )
        
        print(f"✓ DFD successfully generated!")
        print(f"  Output file: {os.path.join(output_dir, output_filename + '.png')}")
        print(f"  Graph source saved as: {os.path.join(output_dir, output_filename)}")
        
        # Optionally, also create an SVG version
        dfd.format = 'svg'
        dfd.render(
            filename=output_filename + '_svg',
            directory=output_dir,
            cleanup=True,
            view=False
        )
        print(f"  SVG version: {os.path.join(output_dir, output_filename + '_svg.svg')}")
        
        # Display the graph source for reference
        print("\nGraph Source Code:")
        print("-" * 50)
        print(dfd.source)
        
    except Exception as e:
        print(f"✗ Error generating DFD: {str(e)}")
        print("Make sure you have graphviz installed:")
        print("  pip install graphviz")
        print("  And ensure Graphviz is installed on your system:")
        print("  - Windows: Download from https://graphviz.org/download/")
        print("  - macOS: brew install graphviz")
        print("  - Ubuntu/Debian: sudo apt-get install graphviz")

if __name__ == "__main__":
    main()