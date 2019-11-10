"""
Base da API
"""

from flask import Flask, jsonify
from flask_cors import CORS
from sqlalchemy import create_engine
import pandas as pd

app = Flask(__name__)
CORS(app)
data = pd.read_csv('D:/igor/OneDrive/Documentos/GitHub/serpro/HackSerpro/datasets/imoveis/imoveis_final_bairro_merged'
                   '.csv',sep=";", encoding="unicode_escape")
engine = create_engine('postgresql://equipe215:ZXF1aXBlMjE1QHNlcnBybw@bd.inova.serpro.gov.br:5432/equipe215')

with engine.connect() as connection:
    columns = connection.execute("SELECT column_name FROM information_schema.columns WHERE table_name='imoveis';")
    columns = columns.fetchall()
    columns = [column[0] for column in columns]

@app.route("/bairros")
def get_bairros():

    """
    Retorna os bairros com valores disponíveis
    :return:
    """
    with engine.connect() as connection:
        response = connection.execute("SELECT DISTINCT x.\"Bairro\" FROM imoveis x ORDER BY x.\"Bairro\";")

    connection.close()

    return jsonify([line[0] for line in response])

@app.route("/bairro/<string:bairro>")
def getBy_bairro(bairro):

    """
    Retorna os imóveis disponíveis em determinado municipio
    :param str bairro:
    :return:
    """
    
    with engine.connect() as connection:
        response = connection.execute("SELECT x.* FROM imoveis x WHERE x.\"Bairro\" = 'CENTRO';").fetchall()
        response = [{columns[i]: line[i] for i in range(len(line))} for line in response]

    return jsonify(response)

@app.route("/valor/<float:valor>")
def getBy_valor(valor):

    """
    Retorna os imóveis disponíveis de acordo com o valor
    :param valor:
    :return:
    """


if __name__ == "__main__":
    app.run(host = 'localhost', port = 7000, debug = False)
