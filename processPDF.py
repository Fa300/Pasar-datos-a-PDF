import pikepdf
import sys
import json

json_data = sys.argv[1]

raw_string = json_data

formatted_string = raw_string.replace("{", '{"').replace(":", '": "').replace(",", '", "').replace("}", '"}')

data = json.loads(formatted_string)

print(data.get("9) 9. Sexo ", "No se encontro la pregunta"))


with pikepdf.Pdf.open('PDFs/Formulario_Sanitas.pdf') as my_pdf:
    for page in my_pdf.pages:
        page.rotate(180, relative=True)
    my_pdf.save('PDFs/Formulario_Sanitas.pdf-rotated.pdf')
